<?php

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

//Front routes start
// Admin routes

use Illuminate\Http\Request;


Route::get('/mypay',function(){
    return Stripe::customers()->find(Auth::user()->customer_id)['subscriptions']['data'][0]['items']['data'][0]['plan']['name'];
});

Route::get('/', function () {
    return redirect(route('login'));
});
Route::get('/temp-login',function(){
    return view('temp-user.login');
});

Route::post('/upgrade','PaymentController@upgrade');

Route::post('/pay-with-stripe','PaymentController@addCard');


Route::get('/createPackage','PaymentController@createPlan');
Route::post('/submit-attachments','AttachmentsController@update');

Route::post('/import-assessments','AssessmentController@import');

Route::post('/show-details','TemporaryUserController@index');
Route::get('/show-details', 'TemporaryUserController@getIndex');
Route::group(
    ['namespace' => 'Front', 'as' => 'jobs.'],
    function () {
        Route::get('/jobs', 'FrontJobsController@jobOpenings')->name('jobOpenings');
        Route::get('/openings/{slug}', 'FrontJobsController@jobByCompany')->name('jobByCompany');
        Route::get('/job/{slug}', 'FrontJobsController@jobDetail')->name('jobDetail');
        Route::get('/job/{slug}/apply', 'FrontJobsController@jobApply')->name('jobApply');
        Route::post('/job/saveApplication', 'FrontJobsController@saveApplication')->name('saveApplication');
        Route::post('/job/saveVideo', 'FrontJobsController@saveVideo')->name('saveVideo');
        Route::post('/job/saveMCQs', 'FrontJobsController@saveMCQs')->name('saveMCQs');
    }
);

//Front routes end


Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::post('mark-notification-read', ['uses' => 'NotificationController@markAllRead'])->name('mark-notification-read');

    // Admin routes
    Route::group(
        ['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'],
        function () {
            Route::get('/library','AdminDashboardController@library');
            Route::get('/dashboard', 'AdminDashboardController@index')->name('dashboard');

            Route::get('firstLogin', 'AdminDashboardController@firstLogin')->name('dashboard.firstLogin');

            Route::get('job-categories/data', 'AdminJobCategoryController@data')->name('job-categories.data');
            Route::get('job-categories/getSkills/{categoryId}', 'AdminJobCategoryController@getSkills')->name('job-categories.getSkills');
            Route::resource('job-categories', 'AdminJobCategoryController');

            //Questions
            Route::get('questions/data', 'AdminQuestionController@data')->name('questions.data');
            Route::resource('questions', 'AdminQuestionController');
            Route::get('company/changlang', ['as' => 'company.langchange', 'uses' => 'AdminCompanyController@changelangfun']);
            Route::post('questions/update', 'AdminQuestionController@update')->name('questions.update');
            Route::delete('questions/destroyAssQuestion/{id}', 'AdminQuestionController@destroyAssQuestion')->name('questions.destroyAssQuestion');

            //Assessments
             Route::get('assessments/data', 'AdminAssessmentController@data')->name('assessments.data');
             Route::get('assessments/fetchassessments', 'AdminAssessmentController@fetchassessments')->name('assessments.fetchassessments');
             Route::get('assessments/fetchAssessementQuestion', 'AdminAssessmentController@fetchAssessementQuestion')->name('assessments.fetchAssessementQuestion');
             Route::resource('assessments', 'AdminAssessmentController');
             Route::post('assessments/saveAssessment', 'AdminAssessmentController@saveAssessment')->name('assessments.saveAssessment');

            // company settings
            Route::group(
                ['prefix' => 'settings'],
                function () {

                    Route::resource('settings', 'CompanySettingsController', ['only' => ['edit', 'update', 'index']]);

                    // Role permission routes
                    Route::resource('settings', 'CompanySettingsController', ['only' => ['edit', 'update', 'index']]);
                    Route::post('role-permission/assignAllPermission', ['as' => 'role-permission.assignAllPermission', 'uses' => 'ManageRolePermissionController@assignAllPermission']);
                    Route::post('role-permission/removeAllPermission', ['as' => 'role-permission.removeAllPermission', 'uses' => 'ManageRolePermissionController@removeAllPermission']);
                    Route::post('role-permission/assignRole', ['as' => 'role-permission.assignRole', 'uses' => 'ManageRolePermissionController@assignRole']);
                    Route::post('role-permission/detachRole', ['as' => 'role-permission.detachRole', 'uses' => 'ManageRolePermissionController@detachRole']);
                    Route::post('role-permission/storeRole', ['as' => 'role-permission.storeRole', 'uses' => 'ManageRolePermissionController@storeRole']);
                    Route::post('role-permission/deleteRole', ['as' => 'role-permission.deleteRole', 'uses' => 'ManageRolePermissionController@deleteRole']);
                    Route::get('role-permission/showMembers/{id}', ['as' => 'role-permission.showMembers', 'uses' => 'ManageRolePermissionController@showMembers']);
                    Route::resource('role-permission', 'ManageRolePermissionController');

                    //language settings
                    Route::get('language-settings/change-language', ['uses' => 'LanguageSettingsController@changeLanguage'])->name('language-settings.change-language');
                    Route::resource('language-settings', 'LanguageSettingsController');

                    Route::resource('theme-settings', 'AdminThemeSettingsController');

                    Route::resource('smtp-settings', 'AdminSmtpSettingController');

                    Route::get('update-application/update', ['as' => 'update-application.updateApp', 'uses' => 'UpdateApplicationController@update']);
                    Route::get('update-application/download', ['as' => 'update-application.download', 'uses' => 'UpdateApplicationController@download']);
                    Route::get('update-application/downloadPercent', ['as' => 'update-application.downloadPercent', 'uses' => 'UpdateApplicationController@downloadPercent']);
                    Route::get('update-application/checkIfFileExtracted', ['as' => 'update-application.checkIfFileExtracted', 'uses' => 'UpdateApplicationController@checkIfFileExtracted']);
                    Route::get('update-application/install', ['as' => 'update-application.install', 'uses' => 'UpdateApplicationController@install']);
                    Route::resource('update-application', 'UpdateApplicationController');
                }
            );


            Route::get('skills/data', 'AdminSkillsController@data')->name('skills.data');
            Route::resource('skills', 'AdminSkillsController');

            Route::get('locations/data', 'AdminLocationsController@data')->name('locations.data');
            Route::resource('locations', 'AdminLocationsController');

            Route::get('jobs/data', 'AdminJobsController@data')->name('jobs.data');
            Route::get('jobs/changeStatus','AdminJobsController@changeStatus');
            Route::get('jobs/changeOrder', 'AdminJobsController@changeOrder')->name('jobs.changeOrder');
            Route::get('jobs/editQuestion', 'AdminJobsController@editQuestion')->name('jobs.editQuestion');
            Route::resource('jobs', 'AdminJobsController');
            Route::post('jobs/saveJob', 'AdminJobsController@saveJob')->name('jobs.saveJob');

            Route::post('jobs/emailForm', 'AdminEmailController@email');

            Route::post('job-applications/rating-save/{id?}', 'AdminJobApplicationController@ratingSave')->name('job-applications.rating-save');
            Route::post('job-applications/score-save/{id?}', 'AdminJobApplicationController@scoreSave')->name('job-applications.score-save');
            Route::get('job-applications/create-schedule/{id?}', 'AdminJobApplicationController@createSchedule')->name('job-applications.create-schedule');
            Route::post('job-applications/store-schedule', 'AdminJobApplicationController@storeSchedule')->name('job-applications.store-schedule');
            Route::get('job-applications/question/{jobID}', 'AdminJobApplicationController@jobQuestion')->name('job-applications.question');
            Route::get('job-applications/export/{status}/{location}/{startDate}/{endDate}/{jobs}', 'AdminJobApplicationController@export')->name('job-applications.export');
            Route::get('job-applications/data', 'AdminJobApplicationController@data')->name('job-applications.data');
            Route::get('job-applications/table-view', 'AdminJobApplicationController@table')->name('job-applications.table');
            Route::post('job-applications/updateIndex', 'AdminJobApplicationController@updateIndex')->name('job-applications.updateIndex');
            Route::resource('job-applications', 'AdminJobApplicationController');

            Route::post('pipeline/rating-save/{id?}', 'AdminPipelineController@ratingSave')->name('pipeline.rating-save');
            Route::get('pipeline/create-schedule/{id?}', 'AdminPipelineController@createSchedule')->name('pipeline.create-schedule');
            Route::post('pipeline/store-schedule', 'AdminPipelineController@storeSchedule')->name('pipeline.store-schedule');
            Route::get('pipeline/question/{jobID}', 'AdminPipelineController@jobQuestion')->name('pipeline.question');
            Route::get('pipeline/export/{status}/{location}/{startDate}/{endDate}/{jobs}', 'AdminPipelineController@export')->name('pipeline.export');
            Route::get('pipeline/data', 'AdminPipelineController@data')->name('pipeline.data');
            Route::get('pipeline/table-view', 'AdminPipelineController@table')->name('pipeline.table');
            Route::post('pipeline/updateIndex', 'AdminPipelineController@updateIndex')->name('pipeline.updateIndex');
            Route::get('pipeline/pipeline/{jobid}', 'AdminPipelineController@pipeline')->name('pipeline.pipeline');
            Route::resource('pipeline', 'AdminPipelineController');
            Route::post('pipeline/reserve-candidate/', 'AdminPipelineController@reservecandidate')->name('pipeline.reserve-candidate');
            Route::post('pipeline/scheduleInterview/', 'AdminPipelineController@scheduleInterview')->name('pipeline.scheduleInterview');
            Route::get('pipeline/showresume/{id}', 'AdminPipelineController@showresume')->name('pipeline.showresume');
            Route::resource('profile', 'AdminProfileController');

            Route::get('interview-schedule/data', 'InterviewScheduleController@data')->name('interview-schedule.data');
            Route::get('interview-schedule/appointment', 'InterviewScheduleController@appointment')->name('interview-schedule.appointment');
            Route::get('interview-schedule/table-view', 'InterviewScheduleController@table')->name('interview-schedule.table-view');
            Route::post('interview-schedule/change-status', 'InterviewScheduleController@changeStatus')->name('interview-schedule.change-status');
            Route::post('interview-schedule/change-status-multiple', 'InterviewScheduleController@changeStatusMultiple')->name('interview-schedule.change-status-multiple');
            Route::get('interview-schedule/notify/{id}/{type}', 'InterviewScheduleController@notify')->name('interview-schedule.notify');
            Route::get('interview-schedule/response/{id}/{type}', 'InterviewScheduleController@employeeResponse')->name('interview-schedule.response');
            Route::resource('interview-schedule', 'InterviewScheduleController');

            Route::get('team/data', 'AdminTeamController@data')->name('team.data');
            Route::post('team/change-role', 'AdminTeamController@changeRole')->name('team.changeRole');
            Route::resource('team', 'AdminTeamController');

            Route::get('company/data', 'AdminCompanyController@data')->name('company.data');

            Route::resource('company', 'AdminCompanyController');
        }
    );
});




Route::get('update-database', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', array('--force' => true));

    return 'Database updated successfully. <a href="' . route('login') . '">Click here to Login</a>';
});