<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order; // Thay thế bằng Model đơn hàng của bạn
use Illuminate\Support\Facades\Auth;
class MomoController extends Controller
{
    public function createPayment(Request $request)
    {
        $orderId = 'ORDER_' . time();
        $amount = 50000; 
        $orderInfo = "Thanh toán đơn hàng qua MoMo";
        
        $order = Order::create([
        'user_id'       => auth()->id(),
        'receiver_name' => $request->input('receiver_name') ?? $request->input('name'), // Sửa 'name' thành 'receiver_name'
        'phone'         => $request->input('phone'),
        'address'       => $request->input('address'),
        'note'          => ($request->input('note') ?? '') . ' [Phương thức: MOMO]',
        'status'        => 'Pending',
    ]);


        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        
        $redirectUrl = route('momo.return');
        $ipnUrl = route('momo.ipn');
        $requestId = time() . "";
        $requestType = "captureWallet";
        $extraData = "";

        $rawHash = "accessKey=" . $accessKey .
                   "&amount=" . $amount .
                   "&extraData=" . $extraData .
                   "&ipnUrl=" . $ipnUrl .
                   "&orderId=" . $orderId .
                   "&orderInfo=" . $orderInfo .
                   "&partnerCode=" . $partnerCode .
                   "&redirectUrl=" . $redirectUrl .
                   "&requestId=" . $requestId .
                   "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Web Ban Quan Ao",
            'storeId' => "StoreId",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];

        $endpoint = env('MOMO_ENDPOINT', 'https://test-payment.momo.v2/gateway/api/create');
        $response = Http::post($endpoint, $data);
        $result = $response->json();

        if (isset($result['payUrl'])) {
            $payUrl = $result['payUrl'];
            $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($payUrl);

            return view('momo.qr', [
                'payUrl'    => $payUrl,
                'qrCodeUrl' => $qrCodeUrl,
                'amount'    => $amount ?? 50000,
                'orderId'   => $orderId ?? 'ORDER_' . time(),
                'orderInfo' => $orderInfo ?? "Thanh toán đơn hàng qua MoMo"
            ]);
        }

        return redirect()->back()->with('error', 'Không thể khởi tạo cổng thanh toán MoMo!');
    }

    /**
     * 2. Xử lý khi user thanh toán xong và được MoMo redirect quay lại website
     */
    public function returnPayment(Request $request)
    {
    $resultCode = $request->input('resultCode');
    $orderId = $request->input('orderId');

    if ($resultCode == 0) {
        // Cập nhật trạng thái đơn hàng thành đã thanh toán
        $order = Order::where('id', $orderId)->first();
        if ($order) {
            $order->update(['status' => 'Paid']);
            // Chuyển sang trang Order Success với ID đơn hàng
            return redirect()->route('orders.success', $order->id)->with('success', 'Thanh toán MoMo thành công!');
        }
    }

    return redirect()->route('checkout.index')->with('error', 'Thanh toán thất bại hoặc bị hủy!');
    }

    /**
     * 3. Nhận thông báo kết quả ngầm Server-to-Server từ MoMo (IPN)
     */
    public function ipn(Request $request)
    {
        Log::info('MoMo IPN Request Received: ', $request->all());

        $secretKey = env('MOMO_SECRET_KEY');
        
        $partnerCode = $request->input('partnerCode');
        $orderId = $request->input('orderId');
        $requestId = $request->input('requestId');
        $amount = $request->input('amount');
        $orderInfo = $request->input('orderInfo');
        $orderType = $request->input('orderType');
        $transId = $request->input('transId');
        $resultCode = $request->input('resultCode');
        $message = $request->input('message');
        $payType = $request->input('payType');
        $responseTime = $request->input('responseTime');
        $extraData = $request->input('extraData');
        $receivedSignature = $request->input('signature');

        // Xác thực chữ ký (Security Check) để đảm bảo request gửi đến từ MoMo thật
        $rawHash = "accessKey=" . env('MOMO_ACCESS_KEY') .
                   "&amount=" . $amount .
                   "&extraData=" . $extraData .
                   "&message=" . $message .
                   "&orderId=" . $orderId .
                   "&orderInfo=" . $orderInfo .
                   "&orderType=" . $orderType .
                   "&partnerCode=" . $partnerCode .
                   "&payType=" . $payType .
                   "&requestId=" . $requestId .
                   "&responseTime=" . $responseTime .
                   "&resultCode=" . $resultCode .
                   "&transId=" . $transId;

        $calculatedSignature = hash_hmac("sha256", $rawHash, $secretKey);

        if ($calculatedSignature !== $receivedSignature) {
            Log::error('MoMo IPN Signature Mismatch!');
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // Xử lý cập nhật trạng thái đơn hàng dựa vào kết quả
        if ($resultCode == 0) {
            // Thành công: Cập nhật Database đơn hàng thành đã thanh toán
            // $order = Order::where('order_id', $orderId)->first();
            // if ($order && $order->status !== 'paid') { $order->update(['status' => 'paid']); }
        } else {
            // Thất bại
        }

        // Phản hồi lại cho MoMo biết đã nhận được thông tin
        return response()->json(['status' => 'success'], 200);
    }
}