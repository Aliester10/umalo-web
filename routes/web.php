    <?php

    use App\Http\Controllers\Admin\MasterData\BidangPerusahaanController;
    use App\Http\Controllers\Admin\MasterData\KategoriController;
    use App\Http\Controllers\Member\Portal\PortalController;
    use App\Http\Controllers\Member\Product\MemberProductController;
use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Guest\Home\HomeController;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Admin\Member\MemberController;
    use App\Http\Controllers\Admin\FAQ\FAQController;
    use App\Http\Controllers\Admin\Monitoring\MonitoringController;
    use App\Http\Controllers\Admin\Parameter\CompanyParameterController;
    use App\Http\Controllers\Admin\Produk\ProdukController;
    use App\Http\Controllers\Guest\Product\ProductGuestController;
    use App\Http\Controllers\Admin\Slider\SliderController;
    use App\Http\Controllers\Admin\Activity\ActivityController;
    use App\Http\Controllers\Admin\Banner\BannerController;
    use App\Http\Controllers\Guest\Activity\ActivityGuestController;
    use App\Http\Controllers\Admin\BrandPartner\BrandPartnerController;
    use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Distributor\DistributorController;
use App\Http\Controllers\Admin\Meta\MetaController;
    use App\Http\Controllers\Guest\Meta\MetaMemberController;
    use App\Http\Controllers\Guest\Contact\ContactGuestController;
    use App\Http\Controllers\Guest\Profile\ProfileMemberController;
    use App\Http\Controllers\Admin\Location\LocationController;
    use App\Http\Controllers\Admin\MasterData\CategoryController;
    use App\Http\Controllers\Admin\Message\MessageController;
    use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\ProformaInvoice\AdminProformaInvoiceController;
use App\Http\Controllers\Admin\PurchaseOrder\AdminPurchaseOrderController;
use App\Http\Controllers\Admin\Quotation\AdminQuotationController;
use App\Http\Controllers\Admin\Quotation\AdminQuotationNegotiationController;
use App\Http\Controllers\Admin\Ticketing\AdminTicketingController;
use App\Http\Controllers\Admin\Visitor\VisitorController;
use App\Http\Controllers\Distributor\Dashboard\DashboardDistributorController;
use App\Http\Controllers\Distributor\Profile\DistributorProfileController;
use App\Http\Controllers\Distributor\ProformaInvoice\DistributorProformaInvoiceController;
use App\Http\Controllers\Distributor\PurchaseOrder\DistributorPurchaseOrderController;
use App\Http\Controllers\Distributor\Quotations\DistributorQuotationController;
use App\Http\Controllers\Distributor\Quotations\DistributorQuotationNegotiationController;
use App\Http\Controllers\Guest\Location\LocationMemberController;
    use App\Http\Controllers\Guest\Meta\MetaGuestController;
use App\Http\Controllers\Member\Dashboard\DashboardMemberController;
use App\Http\Controllers\Member\Profile\MemberProfileController;
use App\Http\Controllers\Member\Ticketing\MemberTicketingController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */


    // Guest Routes (No Authentication Required)

    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['securityheaders']], function() {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/about', [HomeController::class, 'about'])->name('about');
        Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
        Route::get('/contact', [ContactGuestController::class, 'contact'])->name('contact');
        Route::post('/contact', [ContactGuestController::class, 'store'])->name('contact.store');
        
        // Rute lainnya
        Route::get('/products', [ProductGuestController::class, 'index'])->name('product.index');
        Route::get('/products/category/{id}', [ProductGuestController::class, 'index'])->name('product.category');
        Route::get('/product/{slug}', [ProductGuestController::class, 'show'])->name('product.show');
        Route::get('/products/filter/{slug}', [ProductGuestController::class, 'filterByCategory'])->name('filterByCategory');
        
        Route::get('/activity', [ActivityGuestController::class, 'activity'])->name('activity');
        Route::get('/activities/{activity}', [ActivityGuestController::class, 'show'])->name('activity.show');
        Route::get('/meta/{slug}', [MetaGuestController::class, 'showMetaBySlug'])->name('member.meta.show');
        Route::get('/meta', [MetaGuestController::class, 'showMeta'])->name('member.meta.index');
        
        Auth::routes();
    });
    

    Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

        Route::middleware(['auth', 'user-access:member'])->group(function () {
            
            Route::get('/member/dashboard',[DashboardMemberController::class, 'index'])->name('member.dashboard');
            Route::post('/member/update-profile-photo', [DashboardMemberController::class, 'updateProfilePhoto'])->name('member.updateProfilePhoto');

            Route::get('/member/profile/', [MemberProfileController::class, 'index'])->name('member.profile.index');
            Route::post('/member/profile/update', [MemberProfileController::class, 'update'])->name('member.profile.update');

            
            Route::get('/member/products', [MemberProductController::class, 'index'])->name('member.products.index');
            Route::get('/member/products/{id}', [MemberProductController::class, 'show'])->name('member.products.show');
            Route::get('/member/product/{id}/documentation', [MemberProductController::class, 'listDocumentation'])->name('member.product.documentation.list');
            Route::get('/member/documentation/{id}', [MemberProductController::class, 'showDocumentation'])->name('member.documentation.show');
        
            Route::get('/member/ticketing', [MemberTicketingController::class, 'index'])->name('member.ticketing.index');
            Route::get('/member/ticketing/create', [MemberTicketingController::class, 'create'])->name('member.ticketing.create');
            Route::patch('/member/ticketing/{id}/cancel', [MemberTicketingController::class, 'cancel'])->name('member.ticketing.cancel');
            Route::get('/member/ticketing/{id}', [MemberTicketingController::class, 'show'])->name('member.ticketing.show');
            Route::post('/member/ticketing', [MemberTicketingController::class, 'store'])->name('member.ticketing.store');
            Route::get('/member/ticketing/{id}/edit', [MemberTicketingController::class, 'edit'])->name('member.ticketing.edit');
            Route::put('/member/ticketing/{id}', [MemberTicketingController::class, 'update'])->name('member.ticketing.update');
            Route::delete('/member/ticketing/{ticketId}/document/{documentIndex}', [MemberTicketingController::class, 'removeDocument'])->name('member.ticketing.removeDocument');


            Route::get('/portal', [PortalController::class, 'index'])->name('portal');
            Route::get('/portal/user-product', [PortalController::class, 'UserProduct'])->name('portal.user-product');
            Route::get('/product/user-product/{id}', [PortalController::class, 'detailProduk'])->name('user-product.show');
            Route::get('/portal/photos', [PortalController::class, 'photos'])->name('portal.photos');
            Route::get('/portal/instructions', [PortalController::class, 'instructions'])->name('portal.instructions');
            Route::get('/portal/tutorials', [PortalController::class, 'videos'])->name('portal.tutorials');
            Route::get('/portal/controlgenerations', [PortalController::class, 'ControllerGenerations'])->name('portal.controlgenerations');
            Route::get('/portal/document', [PortalController::class, 'document'])->name('portal.document');
            Route::get('/portal/qna', [PortalController::class, 'Faq'])->name('portal.qna');
            Route::get('/portal/monitoring', [PortalController::class, 'Monitoring'])->name('portal.monitoring');
            Route::get('/portal/monitoring/detail/{userProduct}', [PortalController::class, 'showInspeksiMaintenance'])->name('portal.monitoring.detail');
    
        });
    });




    Route::group(['prefix' => LaravelLocalization::setLocale()], function() {

        Route::middleware(['auth', 'user-access:distributor'])->group(function () {
            
            Route::get('/distributor/dashboard',[DashboardDistributorController::class, 'index'])->name('distributor.dashboard');
            Route::post('/distributor/update-profile-photo', [DashboardDistributorController::class, 'updateProfilePhoto'])->name('distributor.updateProfilePhoto');

            Route::get('/distributor/profile/', [DistributorProfileController::class, 'index'])->name('distributor.profile.index');
            Route::post('/distributor/profile/update', [DistributorProfileController::class, 'update'])->name('distributor.profile.update');


            Route::get('/distributor/quotations', [DistributorQuotationController::class, 'index'])->name('distributor.quotations.index');
            Route::get('/distributor/quotations/create', [DistributorQuotationController::class, 'create'])->name('distributor.quotations.create');
            Route::post('/distributor/quotations', [DistributorQuotationController::class, 'store'])->name('distributor.quotations.store');
            Route::get('/distributor/quotations/{id}', [DistributorQuotationController::class, 'show'])->name('distributor.quotations.show');

            
            Route::get('/distributor/quotations/negotiation/create/{quotationId}', [DistributorQuotationNegotiationController::class, 'create'])->name('distributor.quotations.negotiation.create');
            Route::post('/distributor/quotations/negotiation/store/{quotationId}', [DistributorQuotationNegotiationController::class, 'store'])->name('distributor.quotations.negotiation.store');
            Route::get('/distributor/quotations/negotiation/show/{negotiationId}', [DistributorQuotationNegotiationController::class, 'show'])->name('distributor.quotations.negotiation.show');
            Route::patch('quotations/negotiations/{negotiationId}/update-notes', [DistributorQuotationNegotiationController::class, 'updateDistributorNotes'])->name('distributor.quotations.negotiations.updateNotes');
        

            Route::get('/distributor/quotations/purchase-order/{id}', [DistributorPurchaseOrderController::class, 'create'])->name('distributor.purchaseorder.create');
            Route::post('/distributor/quotations/purchase-order/{id}', [DistributorPurchaseOrderController::class, 'store'])->name('distributor.purchaseorder.store');
            
            
            Route::get('/distributor/quotations/proforma-invoice/{id}', [DistributorProformaInvoiceController::class, 'index'])->name('distributor.proformainvoice.index');
            Route::post('/distributor/proforma-invoices/{id}/payment-proof', [DistributorProformaInvoiceController::class, 'submitPaymentProof'])->name('distributor.proforma.submitPaymentProof');
        });
    });



Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::group(['prefix' => LaravelLocalization::setLocale()], function() {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::post('/admin/change-password', [DashboardController::class, 'changePassword'])->name('admin.changePassword');


            Route::get('/admin/visitors', [VisitorController::class, 'index'])->name('admin.visitors');

            Route::resource('admin/product', ProductController::class)->names('admin.product');
            Route::resource('admin/parameter', CompanyParameterController::class);
            Route::resource('admin/category', CategoryController::class)->names('admin.category');
            Route::resource('admin/faq', FAQController::class)->names('admin.faq');
            Route::resource('admin/banner', BannerController::class)->names('admin.banner');
            Route::resource('admin/activity', ActivityController::class)->names('admin.activity');
            Route::resource('admin/meta', MetaController::class)->names('admin.meta');
            Route::post('/froala/upload_image', [MetaController::class, 'uploadImage'])->name('froala.upload_image');
            Route::get('admin/messages', [MessageController::class, 'index'])->name('messages.index');
            Route::get('admin/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
            Route::delete('admin/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
            Route::post('admin/messages/mark-all-read', [MessageController::class, 'markAllAsRead'])->name('messages.markAllRead');

            Route::resource('admin/members', MemberController::class);
            Route::put('/members/{id}/update-password', [MemberController::class, 'updatePassword'])->name('members.update-password');

            Route::post('/admin/validate-password', [MemberController::class, 'validatePassword'])->name('admin.validatePassword');
            Route::get('members/{id}/add-products', [MemberController::class, 'addProducts'])->name('members.add-products');
            Route::post('members/{id}/store-products', [MemberController::class, 'storeProducts'])->name('members.store-products');
            Route::get('members/{id}/edit-products', [MemberController::class, 'editProducts'])->name('members.edit-products');
            Route::put('members/{id}/update-products', [MemberController::class, 'updateProducts'])->name('members.update-products');

            Route::get('/members/products/{id}/documentation/add', [MemberController::class, 'addDocumentation'])->name('members.products.documentation.add');
            Route::post('/members/products/{id}/documentation', [MemberController::class, 'storeDocumentation'])->name('members.products.documentation.store');
            Route::get('/members/products/{id}/documentation', [MemberController::class, 'listDocumentation'])->name('members.products.documentation.list');
            Route::get('/documentation/{id}/show', [MemberController::class, 'showDocumentation'])->name('documentation.show');
            Route::delete('/documentation/{id}/destroy', [MemberController::class, 'destroyDocumentation'])->name('documentation.destroy');
            Route::get('/documentation/{id}/edit', [MemberController::class, 'editDocumentation'])->name('documentation.edit');
            Route::put('/documentation/{id}/update', [MemberController::class, 'updateDocumentation'])->name('documentation.update');
        

            Route::get('/admin/ticketing', [AdminTicketingController::class, 'index'])->name('admin.ticketing.index');
            Route::patch('/admin/ticketing/{id}/update-status', [AdminTicketingController::class, 'updateStatus'])->name('admin.ticketing.update-status');
            Route::patch('/admin/ticketing/{id}/mark-as-viewed', [AdminTicketingController::class, 'markAsViewed'])->name('admin.ticketing.markAsViewed');
            Route::post('/admin/ticketing/{id}/send-data', [AdminTicketingController::class, 'sendRequestData'])->name('admin.ticketing.send-data');




            Route::resource('admin/distributors', DistributorController::class);
            Route::put('/distributors/{id}/update-password', [DistributorController::class, 'updatePassword'])->name('distributors.update-password');
            Route::patch('/distributors/{id}/verify', [DistributorController::class, 'verify'])->name('distributors.verify');


            Route::get('/admin/quotations', [AdminQuotationController::class, 'index'])->name('admin.quotations.index');
            Route::get('/admin/quotations/{id}', [AdminQuotationController::class, 'show'])->name('admin.quotations.show');
            Route::get('/admin/quotations/{id}/edit', [AdminQuotationController::class, 'edit'])->name('admin.quotations.edit');
            Route::put('/admin/quotations/{id}', [AdminQuotationController::class, 'update'])->name('admin.quotations.update'); // Update quotation
            Route::put('/admin/quotations/{id}/reject', [AdminQuotationController::class, 'reject'])->name('admin.quotations.reject');


            
            Route::get('/admin/quotations/negotiation/{negotiationId}', [AdminQuotationNegotiationController::class, 'show'])->name('admin.quotations.negotiation.show');
            Route::put('/admin/quotations/negotiation/{negotiationId}', [AdminQuotationNegotiationController::class, 'update'])->name('admin.quotations.negotiation.update');
            Route::put('quotations/negotiation/{negotiationId}/complete', [AdminQuotationNegotiationController::class, 'complete'])->name('admin.quotations.negotiation.complete');

            Route::get('admin/quotation/{id}/purchase-orders', [AdminPurchaseOrderController::class, 'index'])->name('admin.purchaseorder.index');
            Route::get('/admin/purchaseorder/{id}', [AdminPurchaseOrderController::class, 'show'])->name('admin.purchaseorder.show');
            Route::put('admin/purchase-orders/{id}/approve', [AdminPurchaseOrderController::class, 'approve'])->name('admin.purchaseorder.approve');
            Route::put('admin/purchase-orders/{id}/reject', [AdminPurchaseOrderController::class, 'reject'])->name('admin.purchaseorder.reject');

            Route::get('admin/quotation/{id}/proforma-invoice', [AdminProformaInvoiceController::class, 'index'])->name('admin.proformainvoice.index');
            Route::get('admin/proforma-invoice/{id}', [AdminProformaInvoiceController::class, 'show'])->name('admin.proformainvoice.show');
            Route::get('admin/proforma-invoice/create/{id}', [AdminProformaInvoiceController::class, 'create'])->name('admin.proformainvoice.create');
            Route::post('admin/proforma-invoice/store/{id}', [AdminProformaInvoiceController::class, 'store'])->name('admin.proformainvoice.store');
            Route::put('admin/proforma-invoice//payment-proofs/{id}', [AdminProformaInvoiceController::class, 'update'])->name('admin.proformainvoice.paymentProof.update');

        });
});


