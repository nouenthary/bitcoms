<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DepositConfirmationController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\MainConfirmationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\TransferCoinController;
use App\Http\Controllers\UserConfirmationController;
use App\Http\Controllers\UserInviteController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTitleController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\WithdrawConfirmationController;
use Illuminate\Support\Facades\Route;


// thary task
// register & login for testing
Route::post('/register', [AuthController::class, 'register']);
Route::get('/register_page', [AuthController::class, 'register_page'])->name('register_page');
Route::get('/login', [AuthController::class, 'login_page'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login-post', [AuthController::class, 'login'])->name('login-post');

Route::group(['middleware' => 'auth'], function () {
    // wallet title
    Route::get('/wallet-title-page', [WalletTitleController::class, 'wallet_title_page']);
    Route::resource('/wallet-title', WalletTitleController::class);
    Route::post('/wallet-title/delete', [WalletTitleController::class, 'delete']);
    Route::post('/wallet-title/update', [WalletTitleController::class, 'update']);
    // wallets
    Route::get('/wallet-page', [WalletController::class, 'wallet_page']);
    Route::resource('wallet-address', WalletController::class);
    Route::post('/wallet-address/delete', [WalletController::class, 'delete']);
    // deposits
    Route::get('/deposit-page', [DepositController::class, 'deposit_page']);
    Route::resource('/deposit', DepositController::class);
    Route::post('/deposit-data', [DepositController::class, 'index']);
    // withdrawals
    Route::get('withdrawal-page', [WithdrawalController::class, 'page']);
    Route::resource('withdrawal', WithdrawalController::class);
    Route::post('withdrawals', [WithdrawalController::class, 'index']);
    Route::post('withdrawals-wallet', [WithdrawalController::class, 'show']);
    // transfer coins
    Route::get('/transfer-coin-page', [TransferCoinController::class, 'page']);
    Route::resource('transfer-coin', TransferCoinController::class);
    Route::post('/transfer-coins', [TransferCoinController::class, 'index']);
    Route::get('/transfer-coin-page-admin', [TransferCoinController::class, 'page_admin']);
    //settings
    Route::get('/users-select', [SettingsController::class, 'get_users']);
    Route::get('/get-fee', [SettingsController::class, 'get_fee']);
    Route::get('/get-user-trade', [SettingsController::class, 'get_user_trade']);
    Route::get('/get-user-wallet', [SettingsController::class, 'get_user_wallet']);
    Route::get('/get-wallet-title', [SettingsController::class, 'get_wallet_title']);
    // trade
    Route::get('trade-page', [TradeController::class, 'page_trade']);
    Route::resource('trade', TradeController::class);
    Route::post('get-trade', [TradeController::class, 'index']);
    Route::get('trade-page-transaction', [TradeController::class, 'page_trade_transaction']);
    Route::get('trade-page-transaction-admin', [TradeController::class, 'page_trade_transaction_admin']);
    // users invitation codes 
    Route::post('get-user-invite', [UserInviteController::class, 'index']);
    Route::get('user-invite-page', [UserInviteController::class, 'page_user_invite']);
    Route::get('user-invite-page-admin', [UserInviteController::class, 'page_user_invite_admin']);
    // admin fee
    Route::resource('fee-setting', FeeController::class);
    // notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    // main confirmation
    Route::get('main-confirmation', [MainConfirmationController::class, 'index']);
    // user confirmation
    Route::post('get-user-confirmations', [UserConfirmationController::class, 'get_user_confirmations']);
    Route::get('count-user-confirmations', [UserConfirmationController::class, 'count_user_confirmations']);
    Route::post('post-user-confirmation', [UserConfirmationController::class, 'post_user_confirmation']);
    // wallet confirmation
    Route::post('get-deposit-confirmations', [DepositConfirmationController::class, 'get_deposit_confirmations']);
    Route::get('count-deposit-confirmations', [DepositConfirmationController::class, 'count_deposit_confirmations']);
    Route::post('post-deposit-confirmation', [DepositConfirmationController::class, 'post_deposit_confirmation']);
    // withdraw confirmation
    Route::post('get-withdraw-confirmations', [WithdrawConfirmationController::class, 'get_withdraw_confirmations']);
    Route::get('count-withdraw-confirmations', [WithdrawConfirmationController::class, 'count_withdraw_confirmations']);
    Route::post('post-withdraw-confirmations', [WithdrawConfirmationController::class, 'post_withdraw_confirmation']);
    // privacy
    Route::resource('privacy-page', PrivacyController::class);
    // contact us 
    Route::get('contact-us', [ContactUsController::class, 'contact_us']);
});
// thary task
