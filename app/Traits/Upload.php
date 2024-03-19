<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait Upload
{
    public function UploadFile(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $FileName = !is_null($filename) ? $filename : Str::random(10);
        return $file->storeAs(
            $folder,
            $FileName . "." . $file->getClientOriginalExtension(),
            $disk
        );
    }

    public function deleteFile($path, $disk = 'public')
    {
        Storage::disk($disk)->delete($path);
    }


    public function UploadFileImage(Request $request, $path = 'dev')
    {
        if ($request->hasFile('file')) {
            $prefixName = date('YmdHms');
            $qrimage = $path . '/' . $prefixName . '.' . $request->qrimage->extension();
            $request->qrimage->move(public_path('wallet_title'), $qrimage);
            return $qrimage;
        }
        return '';
    }


    public function UploadFileVoucher(Request $request, $path = 'dev')
    {
        if ($request->hasFile('file')) {
            $prefixName = date('YmdHms');
            $qrimage = $path . '/' . $prefixName . '.' . $request->paymentvoucher->extension();
            $request->paymentvoucher->move(public_path('payment_voucher'), $qrimage);
            return $qrimage;
        }
        return '';
    }


    public function UploadFileCodeLink(Request $request, $path = 'dev')
    {
        if ($request->hasFile('file')) {
            $prefixName = date('YmdHms');
            $qrimage = $path . '/' . $prefixName . '.' . $request->codelink->extension();
            $request->codelink->move(public_path('codelink'), $qrimage);
            return $qrimage;
        }
        return '';
    }


    public function UploadFileLogo(Request $request, $path = 'dev')
    {
        if ($request->hasFile('file')) {
            $prefixName = date('YmdHms');
            $qrimage = $path . '/' . $prefixName . '.' . $request->logo->extension();
            $request->logo->move(public_path('logo'), $qrimage);
            return $qrimage;
        }
        return '';
    }
}
