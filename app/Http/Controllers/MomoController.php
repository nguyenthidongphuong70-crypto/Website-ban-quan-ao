<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order; // Thay thế bằng Model đơn hàng của bạn
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
class MomoController extends Controller
{
    public function createPayment(Request $request)
{
        // 1. Tính tổng tiền từ bảng cart_items của user hiện tại
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $amount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $orderId = 'ORDER_' . time();
        $orderInfo = "Thanh toán đơn hàng qua MoMo";
        
        // 2. Tạo đơn hàng và lưu tổng tiền thực tế vào database
        $order = Order::create([
            'user_id'       => auth()->id(),
            'receiver_name' => $request->input('receiver_name') ?? $request->input('name'),
            'phone'         => $request->input('phone'),
            'address'       => $request->input('address'),
            'note'          => ($request->input('note') ?? '') . ' [Phương thức: MOMO]',
            'total_price'   => $amount, 
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
            'storeId'     => "StoreId",
            'requestId'   => $requestId,
            'amount'      => $amount, 
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl'      => $ipnUrl,
            'lang'        => 'vi',
            'extraData'   => $extraData,
            'requestType' => $requestType,
            'signature'   => $signature,
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
                'amount'    => $amount, 
                'orderId'   => $orderId,
                'orderInfo' => $orderInfo
            ]);
        }

        return redirect()->back()->with('error', 'Không thể khởi tạo cổng thanh toán MoMo!');
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