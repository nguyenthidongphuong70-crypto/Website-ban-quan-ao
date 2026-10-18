<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category')->latest('id');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Configuration::instance([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud.cloud_name'),
                'api_key' => config('cloudinary.cloud.api_key'),
                'api_secret' => config('cloudinary.cloud.api_secret'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);

        if ($request->hasFile('image')) {
            $upload = (new UploadApi())->upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'auren/products',
                ]
            );

            $data['image'] = $upload['secure_url'];
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm mới thành công!');
    }

    public function show(Product $product): View
    {
        $product->load('category');

        return view('products.show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
{
    $data = $request->validated();

    Configuration::instance([
        'cloud' => [
            'cloud_name' => config('cloudinary.cloud.cloud_name'),
            'api_key' => config('cloudinary.cloud.api_key'),
            'api_secret' => config('cloudinary.cloud.api_secret'),
        ],
        'url' => [
            'secure' => true,
        ],
    ]);

    if ($request->hasFile('image')) {
        $upload = (new UploadApi())->upload(
            $request->file('image')->getRealPath(),
            [
                'folder' => 'auren/products',
            ]
        );

        $data['image'] = $upload['secure_url'];
    }

    $product->update($data);

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Cập nhật thông tin sản phẩm thành công!');
}

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Đã xóa sản phẩm thành công!');
    }
}
