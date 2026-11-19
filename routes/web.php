<?php

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\AgentManagementController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\OperationsController;
use App\Http\Controllers\Admin\PackageManagementController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\VisaPassportController;
use App\Http\Controllers\AgentPortalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TourPackageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Travel Agency Website Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

// Destinations
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

// Packages
Route::get('/packages', [TourPackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [TourPackageController::class, 'show'])->name('packages.show');
Route::get('/packages/{slug}/book', [TourPackageController::class, 'bookForm'])->name('packages.book');
Route::post('/packages/{slug}/book', [TourPackageController::class, 'submitBooking'])->name('packages.book.submit');
Route::post('/packages/coupon/check', [TourPackageController::class, 'checkCoupon'])->name('packages.coupon.check');
Route::post('/packages/wishlist/toggle', [TourPackageController::class, 'toggleWishlist'])->name('packages.wishlist.toggle');

// Specialized Travel Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/visa', [ServiceController::class, 'visa'])->name('services.visa');
Route::post('/services/visa', [ServiceController::class, 'submitVisa'])->name('services.visa.submit');

Route::get('/services/passport', [ServiceController::class, 'passport'])->name('services.passport');
Route::post('/services/passport', [ServiceController::class, 'submitPassport'])->name('services.passport.submit');

Route::get('/services/flights', [ServiceController::class, 'flights'])->name('services.flights');
Route::post('/services/flights', [ServiceController::class, 'submitFlight'])->name('services.flights.submit');

Route::get('/services/hotels', [ServiceController::class, 'hotels'])->name('services.hotels');
Route::post('/services/hotels', [ServiceController::class, 'submitHotel'])->name('services.hotels.submit');

Route::get('/services/trains', [ServiceController::class, 'trains'])->name('services.trains');
Route::post('/services/trains', [ServiceController::class, 'submitTrain'])->name('services.trains.submit');

Route::get('/services/buses', [ServiceController::class, 'buses'])->name('services.buses');
Route::post('/services/buses', [ServiceController::class, 'submitBus'])->name('services.buses.submit');

Route::get('/services/custom-tour', [ServiceController::class, 'customTour'])->name('services.custom_tour');
Route::post('/services/custom-tour', [ServiceController::class, 'submitCustomTour'])->name('services.custom_tour.submit');

// Blogs & Travel Stories
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Self-Service Portal Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [CustomerDashboardController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{id}', [CustomerDashboardController::class, 'bookingDetails'])->name('bookings.show');
    Route::get('/vouchers/{id}/download', [CustomerDashboardController::class, 'downloadVoucher'])->name('voucher.download');
    Route::get('/invoices/{id}/download', [CustomerDashboardController::class, 'downloadInvoice'])->name('invoice.download');
    Route::get('/inquiries', [CustomerDashboardController::class, 'inquiries'])->name('inquiries');
    Route::get('/visa-passport', [CustomerDashboardController::class, 'visaPassport'])->name('visa_passport');
    Route::get('/passengers', [CustomerDashboardController::class, 'passengers'])->name('passengers');
    Route::post('/passengers', [CustomerDashboardController::class, 'storePassenger'])->name('passengers.store');
    Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/wishlist', [CustomerDashboardController::class, 'wishlist'])->name('wishlist');
    Route::get('/support', [CustomerDashboardController::class, 'support'])->name('support');
    Route::post('/support', [CustomerDashboardController::class, 'storeTicket'])->name('support.store');
    Route::get('/support/{id}', [CustomerDashboardController::class, 'ticketDetails'])->name('support.show');
    Route::post('/support/{id}/reply', [CustomerDashboardController::class, 'replyTicket'])->name('support.reply');
});

/*
|--------------------------------------------------------------------------
| B2B Travel Agent Portal Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [AgentPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/packages', [AgentPortalController::class, 'packages'])->name('packages');
    Route::get('/packages/{id}/book', [AgentPortalController::class, 'createBookingForm'])->name('bookings.create');
    Route::post('/packages/{id}/book', [AgentPortalController::class, 'submitBooking'])->name('bookings.store');
    Route::get('/bookings', [AgentPortalController::class, 'bookings'])->name('bookings');
    Route::get('/wallet', [AgentPortalController::class, 'wallet'])->name('wallet');
    Route::get('/commissions', [AgentPortalController::class, 'commissions'])->name('commissions');
});

/*
|--------------------------------------------------------------------------
| Admin CRM / ERP Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Leads & Follow-ups
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/{id}', [LeadController::class, 'show'])->name('leads.show');
    Route::post('/leads/{id}/status', [LeadController::class, 'updateStatus'])->name('leads.status.update');
    Route::post('/leads/{id}/followup', [LeadController::class, 'addFollowup'])->name('leads.followup.store');
    Route::post('/leads/{id}/activity', [LeadController::class, 'addActivity'])->name('leads.activity.store');
    Route::post('/leads/{id}/convert', [LeadController::class, 'convertToCustomer'])->name('leads.convert.customer');

    // Customer CRM
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::post('/customers/{id}/passengers', [CustomerController::class, 'addPassenger'])->name('customers.passengers.store');

    // Tour Packages & Itineraries
    Route::get('/packages', [PackageManagementController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [PackageManagementController::class, 'create'])->name('packages.create');
    Route::post('/packages', [PackageManagementController::class, 'store'])->name('packages.store');
    Route::get('/packages/{id}', [PackageManagementController::class, 'show'])->name('packages.show');
    Route::get('/packages/{id}/edit', [PackageManagementController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{id}', [PackageManagementController::class, 'update'])->name('packages.update');
    Route::post('/packages/{id}/itinerary', [PackageManagementController::class, 'addItinerary'])->name('packages.itineraries.store');
    Route::post('/packages/{id}/departure', [PackageManagementController::class, 'addDeparture'])->name('packages.departures.store');

    // Central Bookings
    Route::get('/bookings', [BookingManagementController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingManagementController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/status', [BookingManagementController::class, 'updateStatus'])->name('bookings.status.update');
    Route::post('/bookings/{id}/payment', [BookingManagementController::class, 'collectPayment'])->name('bookings.payment.collect');
    Route::post('/bookings/{id}/voucher', [BookingManagementController::class, 'generateVoucher'])->name('bookings.voucher.generate');
    Route::post('/bookings/{id}/invoice', [BookingManagementController::class, 'issueInvoice'])->name('bookings.invoice.issue');
    Route::post('/bookings/{id}/cancel', [BookingManagementController::class, 'cancelBooking'])->name('bookings.cancel');

    // Quotations
    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/create', [QuotationController::class, 'create'])->name('quotations.create');
    Route::post('/quotations', [QuotationController::class, 'store'])->name('quotations.store');
    Route::get('/quotations/{id}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::get('/quotations/{id}/pdf', [QuotationController::class, 'downloadPdf'])->name('quotations.pdf.download');
    Route::post('/quotations/{id}/convert', [QuotationController::class, 'convertToBooking'])->name('quotations.convert');
    Route::post('/quotations/{id}/convert-booking', [QuotationController::class, 'convertToBooking'])->name('quotations.convert.booking');

    // Visa & Passport Operations
    Route::get('/visa', [VisaPassportController::class, 'visaIndex'])->name('visa.index');
    Route::get('/visa/{id}', [VisaPassportController::class, 'visaShow'])->name('visa.show');
    Route::post('/visa/{id}/status', [VisaPassportController::class, 'updateVisaStatus'])->name('visa.status');

    Route::get('/passport', [VisaPassportController::class, 'passportIndex'])->name('passport.index');
    Route::get('/passport/{id}', [VisaPassportController::class, 'passportShow'])->name('passport.show');
    Route::post('/passport/{id}/status', [VisaPassportController::class, 'updatePassportStatus'])->name('passport.status');

    // Tour Operations & Trips
    Route::get('/operations', [OperationsController::class, 'tripsIndex'])->name('operations.index');
    Route::get('/operations/trips/{id}', [OperationsController::class, 'tripShow'])->name('operations.show');
    Route::post('/operations/trips/{id}', [OperationsController::class, 'updateTrip'])->name('operations.update');
    Route::post('/operations/trips/{id}/assign', [OperationsController::class, 'assignSupplier'])->name('operations.assign');

    // Suppliers & Vendors
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');

    // Accounts, Invoicing & GST
    Route::get('/accounts/payments', [AccountsController::class, 'paymentsIndex'])->name('accounts.payments');
    Route::get('/accounts/invoices', [AccountsController::class, 'invoicesIndex'])->name('accounts.invoices');
    Route::get('/accounts/invoices/{id}', [AccountsController::class, 'invoiceShow'])->name('accounts.invoice.show');
    Route::get('/accounts/invoices/{id}/pdf', [AccountsController::class, 'downloadInvoicePdf'])->name('accounts.invoice.pdf');
    Route::get('/accounts/expenses', [AccountsController::class, 'expensesIndex'])->name('accounts.expenses');
    Route::get('/accounts/expenses/create', [AccountsController::class, 'createExpense'])->name('accounts.expenses.create');
    Route::post('/accounts/expenses', [AccountsController::class, 'storeExpense'])->name('accounts.expenses.store');
    Route::get('/accounts/gst', [AccountsController::class, 'gstReport'])->name('accounts.gst');

    // B2B Partner Management
    Route::get('/agents', [AgentManagementController::class, 'index'])->name('agents.index');
    Route::get('/agents/{id}', [AgentManagementController::class, 'show'])->name('agents.show');
    Route::post('/agents/{id}/status', [AgentManagementController::class, 'updateStatus'])->name('agents.status.update');

    // Employees & Roles
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

    // CMS & Content
    Route::get('/cms', [CmsController::class, 'index'])->name('cms.index');
    Route::post('/cms/banner', [CmsController::class, 'storeBanner'])->name('cms.banner.store');
    Route::post('/cms/testimonial', [CmsController::class, 'storeTestimonial'])->name('cms.testimonial.store');
    Route::post('/cms/blog', [CmsController::class, 'storeBlog'])->name('cms.blog.store');
    Route::post('/cms/faq', [CmsController::class, 'storeFaq'])->name('cms.faq.store');

    // Reports & Analytics
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/bookings/csv', [ReportController::class, 'exportBookingsCsv'])->name('reports.bookings.csv');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});
