<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\SubModuleController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Student\StudentCommonController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\StripePaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\KhdaCertificateController;
use App\Http\Controllers\Admin\PaymentDeatilsController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ShortAnswerController;
use App\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// front student login
Route::get('register',[LoginController::class,'register'])->name('register');
Route::post('student-register',[LoginController::class,'studentRegister'])->name('student-register');
Route::get('student-verify',[LoginController::class,'studentVerify'])->name('student-verify');
Route::get('student-login-from/{id}',[LoginController::class,'studentLoginFrom'])->name('student-login-from');
Route::get('student-resend-mail',[LoginController::class,'resendMail'])->name('student-resend-mail');


Route::middleware(['student-auth'])->group(function () {
    Route::get('student-details-form',[LoginController::class,'studentDetailsForm'])->name('student-details-form');
});

Route::post('student-authenticate',[LoginController::class,'studentAuthenticate'])->name('student-authenticate');

//front student login
Route::get('login',[LoginController::class,'login'])->name('login');
Route::post('user_login',[LoginController::class,'userLogin'])->name('user_login');


Route::get('/',[FrontController::class,'index'])->name('home');
Route::get('about',[FrontController::class,'about'])->name('about');
Route::get('service',[FrontController::class,'service'])->name('service');
Route::get('training',[FrontController::class,'training'])->name('training');
Route::get('training-details/{id}',[FrontController::class,'trainingDetails'])->name('training-details');
Route::get('blog',[FrontController::class,'blog'])->name('blog');
Route::get('blog-details/{id}',[FrontController::class,'blogDetails'])->name('blog-details');
Route::get('contact',[FrontController::class,'contact'])->name('contact');
Route::get('category-filter',[FrontController::class,'categoryFilter'])->name('category-filter');

Route::get('course/{id}/detail',[FrontController::class,'courseDetail'])->name('courseDetail');
Route::any('auth-modal',[FrontController::class,'authModal'])->name('authModal');
Route::post('subscription-plan',[FrontController::class,'subscriptionPlan'])->name('subscription-plan');
Route::post('remove_plan_purchase',[FrontController::class,'removePlanPurchase'])->name('remove_plan_purchase');

Route::post('subscription-one-time',[FrontController::class,'subscriptionOneTime'])->name('subscription-one-time');
// Route with both parameters
Route::post('course/{id}/modal',[FrontController::class,'enrolModal'])->name('enrolModal');
Route::post('course/{id}/enrol', [FrontController::class, 'courseEnrol'])->name('course.enrol');


Route::post('enquirysave',[FrontController::class,'enquirySave'])->name('enquirysave');
Route::post('add-component',[CommonController::class,'addComponent'])->name('addComponent');
Route::post('payment/{cart?}/{priceId?}', [PaymentController::class,'initiatePayment'])->name('initiatePayment');
Route::post('payment-callback', [PaymentController::class,'handleCallback'])->name('handleCallback');
Route::post('payment-success', [PaymentController::class,'successPayment'])->name('successPayment');
Route::middleware(['student-auth','student-details'])->group(function () {

    Route::prefix('student')->name('student.')->namespace('App\Http\Controllers\Student')->group(function () {
        Route::get('dashboard','StudentCommonController@index')->name('dashboard');
        Route::get('my-learning','StudentCommonController@myLearning')->name('my-learning');
        Route::prefix('assignment/{id}')->name('assignment.')->group(function (){

            Route::get('/', 'StudentAssignmentController@show')->name('show');
            Route::put('/', 'StudentAssignmentController@start')->name('start');
            Route::post('/', 'StudentAssignmentController@submit')->name('submit');
        });
        Route::prefix('material/{id}')->name('material.')->group(function (){
            Route::get('/', 'StudentMaterialController@show')->name('show');
            Route::post('markAsCompleted', 'StudentMaterialController@markAsCompleted')->name('markAsCompleted');
        });
        Route::get('assignment-data/{id}','StudentAssignmentController@assignmentDta')->name('assignment-data');

        Route::get('assignment-data-show/{id}', 'StudentAssignmentController@assignmentDataShow')->name('assignment-data-show');


        Route::post('change-password',[StudentCommonController::class,'changePassword'])->name('changePassword');
        Route::get('accomplishments',[StudentCommonController::class,'accomplishments'])->name('accomplishments');

        Route::get('generate-certificate',[StudentCommonController::class,'generate_certificate'])->name('generate_certificate');

        Route::get('course/{id}',[StudentCommonController::class,'courseDetails'])->name('course.show');
        Route::get('/material/ppt/{id}',[StudentCommonController::class, 'showPpt'])->name('ppt.show');

        Route::get('purchases',[StudentCommonController::class,'myPurchase'])->name('purchases');
        Route::get('grades/{id}',[StudentCommonController::class,'grades'])->name('grades');
    });

    Route::post('payment-attested', [PaymentController::class,'attestedKHDAPayment'])->name('payment-attested');
    Route::post('/student/course/complete', [StudentCommonController::class, 'markCourseAsCompleted'])->name('student.course.complete');
    Route::post('/check-email-unique', [PaymentController::class, 'checkEmailUnique'])->name('check-email-unique');


    //student dashboard


    Route::get('course-material-details/{id}',[StudentCommonController::class,'courseMaterial'])->name('course-material-details');
    Route::get('course-material-title/{id}',[StudentCommonController::class,'courseMaterialTitle'])->name('course-material-title');
    Route::get('course-material-quize/{id}',[StudentCommonController::class,'courseMaterialQuize'])->name('course-material-quize');
    Route::get('course-quize/{id}',[StudentCommonController::class,'courseQuize'])->name('course-quize');

    Route::get('module-filter',[StudentCommonController::class,'moduleFilter'])->name('module-filter');
    Route::get('course-material-attempt',[StudentCommonController::class,'courseMaterialAttempt'])->name('course-material-attempt');

    Route::post('student-assignments-save',[StudentCommonController::class,'studentAssignmentsSave'])->name('student-assignments-save');
    Route::get('/preview/{id}', [StudentCommonController::class, 'quize_preview'])->name('preview');


    Route::get('edit-profile',[StudentCommonController::class,'editProfile'])->name('edit-profile');
    Route::post('profile-save',[StudentCommonController::class,'profileSave'])->name('profile-save');

    Route::post('rating',[StudentCommonController::class,'storeRating'])->name('rating');

    Route::resource('cart',CartController::class);
    Route::get('checkout/{cart?}/{priceId?}', [CartController::class, 'checkout'])->name('checkout');

    Route::post('/get-course-data', [CartController::class, 'getCourseData']);




});


// admin login
Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('login',[AdminController::class,'adminLogin'])->name('login');
});
Route::post('/authenticated',[AdminController::class,'authenticate'])->name('admin.authenticate');
Route::get('logout',[LoginController::class,'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {


    Route::name('admin.')->prefix('admin')->group(function () {
        Route::resource('options',OptionController::class);
        Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');

    });
    Route::resource('roles',RoleController::class)->except(['update']);
    Route::resource('permissions',PermissionController::class)->except(['show','create']);
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::put('{role}/change-status',[RoleController::class,'changeStatus'])->name('changeStatus');
        Route::get('{role}/permissions',[RoleController::class,'permissionIndex'])->name('permissionIndex');
        Route::post('{role}/permissions',[RoleController::class,'permissionStore'])->name('permissionStore');
    });

    //role permission
    Route::get('/roles/permission/{id}',[RoleController::class,'getAddPermissionPage'])->name('/roles/permission');
    Route::post('/roles/permission/update',[RoleController::class,'addPermission'])->name('roles/permission/update');

    //user manage role
    Route::get('user-roles-list',[UserController::class,'index'])->name('user-roles.index');
    Route::match(['get','post'],'/user-role-create',[UserController::class,'userCreate'])->name('user-role-create');
    Route::get('user/role/edit/{id}',[UserController::class,'userRoleEdit'])->name('user-role-edit');
    Route::post('user-roles-update',[UserController::class,'userRoleUpdate'])->name('user-role-update');
    Route::post('user-role-delete',[UserController::class,'userRoleDelete'])->name('user-role-delete');
    Route::post('user-role-status',[UserController::class,'userRolesStatus'])->name('user-role-status');
    Route::get('/user/details/{id}', [UserController::class, 'details']);


    //category route
    Route::get('category',[CategoryController::class,'index'])->name('category.index');
    Route::match(['get','post'],'/category-create',[CategoryController::class,'create'])->name('category-create');
    Route::get('category/edit/{id}',[CategoryController::class,'categoryEdit'])->name('categoryEdit');
    Route::post('category-update',[CategoryController::class,'categoryUpdate'])->name('category-update');
    Route::post('category-delete',[CategoryController::class,'categoryDelete'])->name('category-delete');
    Route::post('category-status',[CategoryController::class,'categoryStatus'])->name('category-status');


    //category route
    Route::get('course',[CourseController::class,'index'])->name('course.index');
    Route::match(['get','post'],'/course-create',[CourseController::class,'create'])->name('course-create');
    Route::get('course/edit/{id}',[CourseController::class,'courseEdit'])->name('course.edit');
    Route::post('course',[CourseController::class,'store'])->name('course.store');
    Route::delete('price-option/{id}',[CourseController::class,'priceOptionDestroy'])->name('priceOptionDestroy');
    Route::delete('objective/{id}',[CourseController::class,'objectiveDestroy'])->name('objectiveDestroy');
    Route::post('course-delete',[CourseController::class,'courseDelete'])->name('course-delete');
    Route::post('course-status',[CourseController::class,'courseStatus'])->name('course-status');
    Route::post('course-delete-price',[CourseController::class,'courseDeletePrice'])->name('course-delete-price');

    //course module
    Route::get('course/add_module/{id}',[CourseController::class,'add_module'])->name('module.add');
    Route::get('course-module-list',[ModuleController::class,'courseModuleList'])->name('course-module-list');
    Route::post('course-module_create',[ModuleController::class,'courseModuleCreate'])->name('course-module_create');
    Route::get('course/module/edit/{id}',[ModuleController::class,'courseModuleEdit'])->name('module.edit');
    Route::post('course-module_update',[ModuleController::class,'courseModuleUpdate'])->name('course-module_update');
    Route::post('module-delete',[ModuleController::class,'moduleDelete'])->name('module-delete');
    Route::post('module-status',[ModuleController::class,'moduleStatus'])->name('module-status');

     //sub module name
     Route::get('sub-module-list',[SubModuleController::class,'index'])->name('sub-module-list');
     Route::get('/sub-module-create/{id}',[SubModuleController::class,'create'])->name('sub-module.create');
     Route::post('/sub-module-store',[SubModuleController::class,'store'])->name('sub-module-store');
     Route::get('sub/module/edit/{id}',[SubModuleController::class,'subModuleEdit'])->name('sub-module.edit');
     Route::post('sub-module_update',[SubModuleController::class,'subModuleUpdate'])->name('sub-module_update');
     Route::post('sub-module-delete',[SubModuleController::class,'subModuleDelete'])->name('sub-module-delete');
     Route::post('sub-module-status',[SubModuleController::class,'subModuleStatus'])->name('sub-module-status');
     Route::get('sub-modules/{id}/materials',[MaterialController::class,'materialsIndex'])->name('materialsIndex');
     Route::post('sub-modules/{id}/materials',[MaterialController::class,'materialsStore'])->name('materialsStore');
     Route::get('sub-modules/{id}/assignments',[AssignmentController::class,'assignmentIndex'])->name('assignmentIndex');
     Route::post('sub-modules/{id}/assignments',[AssignmentController::class,'assignmentsStore'])->name('assignmentsStore');
     Route::post('material-delete',[MaterialController::class,'materialDelete'])->name('material-delete');

     Route::post('assignments/{id}',[AssignmentController::class,'assignmentDestroy'])->name('assignmentDestroy');
     Route::get('assignments/{id}/questions',[QuestionController::class,'questionIndex'])->name('questionIndex');
     Route::post('assignments/{id}/questions',[QuestionController::class,'questionStore'])->name('questionStore');
     Route::post('questions/{id}',[QuestionController::class,'questionDestroy'])->name('questionDestroy');
    //  Route::post('options/{id}',[OptionController::class,'destroy'])->name('destroy');

    //certification route
    Route::get('certification',[CertificationController::class,'index'])->name('certification.index');
    Route::match(['get','post'],'/certification-create',[CertificationController::class,'create'])->name('certification-create');
    Route::get('certification/edit/{id}',[CertificationController::class,'certificationEdit'])->name('certification-edit');
    Route::post('certification-update',[CertificationController::class,'certificationUpdate'])->name('certification-update');
    Route::post('certification-delete',[CertificationController::class,'certificationDelete'])->name('certification-delete');
    Route::post('certification-status',[CertificationController::class,'certificationStatus'])->name('certification-status');

    //course materials
     Route::get('course-material',[MaterialController::class,'index'])->name('course-material');
     Route::get('/course-material-create/{id}',[MaterialController::class,'create'])->name('course-material-create');
     Route::post('/course-material-store',[MaterialController::class,'store'])->name('course-material-store');
     Route::get('course-material/edit/{id}',[MaterialController::class,'courseMaterialEdit'])->name('course-material-edit');
     Route::post('course-material-update',[MaterialController::class,'courseMaterialUpdate'])->name('course-material-update');
     Route::post('course-material-delete',[MaterialController::class,'courseMaterialDelete'])->name('course-material-delete');
     Route::post('course-material-status',[MaterialController::class,'courseMaterialStatus'])->name('course-material-status');

     Route::post('/sub-module-data',[MaterialController::class,'subModuleData'])->name('/sub-module-data');


     // assignment route
     Route::get('assignment-list',[AssignmentController::class,'index'])->name('assignment-list');
     Route::get('/course/assignment_add/{id}',[AssignmentController::class,'create'])->name('ass-create');
     Route::post('assignment-store',[AssignmentController::class,'assignmentStore'])->name('assignment-store');
     Route::get('assignment/edit/{id}',[AssignmentController::class,'assignmentEdit'])->name('ass-edit');
     Route::post('assignment-update',[AssignmentController::class,'assignmentUpdate'])->name('assignment-update');
     Route::post('assignment-delete',[AssignmentController::class,'assignmentDelete'])->name('assignment-delete');
     Route::post('assignment-status',[AssignmentController::class,'assignmentStatus'])->name('assignment-status');
     Route::get('assignment-show/{id}',[AssignmentController::class,'assignmentShow'])->name('assignment-show');
     Route::post('assignment-publish',[AssignmentController::class,'assignmentPublish'])->name('assignment-publish');



     //quize route
     Route::get('quize-list',[QuizController::class,'index'])->name('quize-list');
     Route::get('/course/quize_add/{id}',[QuizController::class,'create'])->name('quize-create');
     Route::post('quize-store',[QuizController::class,'quizeStore'])->name('quize-store');
     Route::get('quize/edit/{id}',[QuizController::class,'quizeEdit'])->name('quize-edit');
     Route::post('quize-update',[QuizController::class,'quizeUpdate'])->name('quize-update');
     Route::post('quize-delete',[QuizController::class,'quizeDelete'])->name('quize-delete');
     Route::post('quize-status',[QuizController::class,'quizeStatus'])->name('quize-status');

     // question route
     Route::get('question-list',[QuestionController::class,'index'])->name('question-list');
     Route::get('/quize/question/{id}',[QuestionController::class,'create'])->name('question-quiz-create');
     Route::post('question-quize-save',[QuestionController::class,'questionQuizeSave'])->name('question-quize-save');
     Route::get('question-quize/{id}',[QuestionController::class,'questionEdit'])->name('question-quize-edit');
     Route::post('question-quize-update',[QuestionController::class,'questionUpdate'])->name('question-quize-update');
     Route::post('question-quize-delete',[QuestionController::class,'questionDelete'])->name('question-quize-delete');
     Route::post('question-status',[QuestionController::class,'questionStatus'])->name('question-status');

     //blogs route
     Route::get('blogs-list',[BlogController::class,'index'])->name('blogs.index');
     Route::match(['get','post'],'/blogs-create',[BlogController::class,'create'])->name('blogs-create');
     Route::get('blogs/edit/{id}',[BlogController::class,'blogEdit'])->name('blogs-edit');
     Route::post('blogs-update',[BlogController::class,'blogsUpdate'])->name('blogs-update');
     Route::post('blog-delete',[BlogController::class,'blogDelete'])->name('blog-delete');
     Route::post('blog-status',[BlogController::class,'blogStatus'])->name('blog-status');

     //skills route
    Route::get('skills-list',[SkillController::class,'index'])->name('skills.index');
    Route::match(['get','post'],'/skills-create',[SkillController::class,'create'])->name('skills-create');
    Route::get('skills/edit/{id}',[SkillController::class,'skillsEdit'])->name('skills-edit');
    Route::post('skills-update',[SkillController::class,'skillsUpdate'])->name('skills-update');
    Route::post('skills-delete',[SkillController::class,'skillsDelete'])->name('skills-delete');
    Route::post('skills-status',[SkillController::class,'skillsStatus'])->name('skills-status');

    //chatify
    Route::get('chat-list',[ChatController::class,'index'])->name('chat.index');

    Route::get('khda-certificate',[KhdaCertificateController::class,'index'])->name('khda-certificate');
    Route::get('khda-certificate-get',[KhdaCertificateController::class,'getData'])->name('khda-certificate-get');
    Route::post('khda-certificate-approve',[KhdaCertificateController::class,'approvedStatus'])->name('khda-certificate-approve');

    //short Answer
    Route::get('short-list',[ShortAnswerController::class,'index'])->name('short-list');
    Route::get('short-answer/{id}',[ShortAnswerController::class,'showAnswerAndQuestion'])->name('short-answer');
    Route::post('short-answer-store',[ShortAnswerController::class,'answerSubmit'])->name('short-answer-store');


    //
    Route::get('review-list',[ReviewController::class,'index'])->name('review-list');
    Route::get('review-show',[ReviewController::class,'getReview'])->name('review-show');

    //payment status
    Route::get('payment-list',[PaymentDeatilsController::class,'index'])->name('payment-list');
    Route::get('export-all-payments',[PaymentController::class,'exportAllPayments'])->name('export-all-payments');

});

