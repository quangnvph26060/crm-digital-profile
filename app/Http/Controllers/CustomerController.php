<?php

namespace App\Http\Controllers;

use App\Models\DataAds;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerForm()
    {
        return view("customer_form");
    }

    public function listCustomer()
    {
        $customers = DataAds::where("user_id", auth()->user()->id)->latest()->get();

        return view("customers.pages.list", [
            "customers" => $customers
        ]);
    }

    public function createCustomer()
    {
        return view("customers.pages.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "info.name" => "required",
            "info.phone" => "required",
            "info.position" => "required",
            "info.content" => "required"
        ]);
        $data = $request->except("_token");
        DataAds::create(["content" => json_encode($data), "user_id" => auth()->user()->id]);

        return back()->with("success", "Thêm thông tin thành công");
    }

    public function storeCustomer(Request $request)
    {
        $this->validate($request, [
            "info.name" => "required",
            "info.phone" => "required",
            "info.email" => "required|email",
            "info.position" => "required",
            "info.company" => "required",
            "info.activity" => "required",
            "overview.reason" => "required",
            "overview.product" => "required",
            "overview.budget" => "required|numeric",
            "overview.time" => "required",
            "overview.keyword" => "required",
            "experience.exp_seo" => "required",
            "experience.reason" => "required",
            "experience.wish" => "required",
            "website.url" => "required",
            "product.industry" => "required",
            "product.price_product" => "required",
            "product.strengths" => "required",
            "product.social" => "required",
        ]);
        $data = $request->except("_token");
        DataAds::create(["content" => json_encode($data)]);

        return back()->with("success", "Gửi thông tin thành công");
    }

    public function getListCustomer()
    {
        $customers = DataAds::latest()->with("user")->get();

        return view("admins.pages.customers.list", ["customers" => $customers]);
    }

    public function delete($id)
    {
        DataAds::where("id", $id)->delete();

        return back()->with("success", "Xóa thành công");
    }

    public function getDetailCustomer($id)
    {
        $customer = DataAds::find($id);

        return view("admins.pages.customers.detail", [
            "customer" => json_decode($customer->content, true),
            "config" => config("constant.customer"),
            "title_section" => config("constant.customer.title_section")
        ]);
    }
}
