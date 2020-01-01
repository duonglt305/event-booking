<?php

Route::get('', function () {
    return redirect()->route('dashboard');
});
Route::prefix('organizer')->group(function () {
    Route::get('sign-in', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('sign-in', 'Auth\LoginController@login');
    Route::post('sign-out', 'Auth\LoginController@logout')->name('logout');
    Route::get('sign-up', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('sign-up', 'Auth\RegisterController@register');

    Route::get('forgot-password', 'Auth\ForgotPasswordController@showForgotForm')->name('forgot_password');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@sendMail')->name('forgot_password');
    Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@resetPassShow')->name('reset_password_show');
    Route::post('reset-password', 'Auth\ForgotPasswordController@resetPass')->name('reset_password');

    Route::middleware(['auth'])->group(function () {
        Route::get('', function () {
            return redirect()->route('dashboard');
        });

        Route::get('change-password', 'Auth\ChangePasswordController@showChangePassword')->name('organizer.show_change_password');
        Route::post('change-password', 'Auth\ChangePasswordController@changePassword')->name('organizer.change_password');

        Route::get('notify', 'NotifyController@index')->name('organizer.notify');
        Route::post('notify-datatable', 'NotifyController@datatable')->name('organizer.notify_datatable');
        Route::post('mask-as-read-notifications', 'NotifyController@maskAsRead')->name('organizer.mask_as_read_notifications');
        Route::post('mask-as-read-one-notifications', 'NotifyController@maskAsReadOne')->name('organizer.mask_as_read_one_notifications');

        Route::get('contact', 'ContactController@index')->name('organizer.contact');
        Route::post('contact-datatable', 'ContactController@datatable')->name('organizer.contact_datatable');
        Route::post('mask-as-read-contact', 'ContactController@maskAsRead')->name('organizer.mask_as_read_contact');
        Route::post('mask-as-read-all-contact', 'ContactController@maskAsReadAll')->name('organizer.mask_as_read_all_contact');


        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('dashboard-data', 'DashboardController@getData')->name('dashboard.get_data');
        Route::resource('events', 'EventController');
        Route::prefix('events/{event}')->group(function () {

            Route::prefix('attendees-verify')->group(function () {
                Route::get('', 'EventController@attendeesVerifyShow')->name('events.attendees_verify_show');
                Route::post('get-verify-info', 'EventController@attendeesVerify')->name('events.attendees_verify');
                Route::post('verify', 'EventController@attendeesVerifyUpdate')->name('event.attendees_verify.update');
                Route::get('session-select', 'EventController@sessionSelect')->name('events.session_select');
            });

            Route::post('update-status-event', 'EventController@updateStatus')->name('events.update_status_event');

            /* ticket */
            Route::resource('tickets', 'TicketController');
            /* channel */
            Route::resource('channels', 'ChannelController');
            /* room */
            Route::post('rooms/datatable', 'RoomController@datatable')->name('rooms.datatable');
            /*  session */
            Route::post('sessions/datatable', 'SessionController@datatable')->name('sessions.datatable');
            Route::patch('sessions/update/{session_id}', 'SessionController@update')->name('sessions.update');
            Route::resource('sessions', 'SessionController')->except('update');
            /* session type */
            Route::get('session-types/select2', 'SessionTypeController@select2')->name('session-types.select2');
            Route::patch('session-types/bulk-changes-name', 'SessionTypeController@bulkChangeName')->name('session-types.bulk_changes_name');
            Route::patch('session-types/bulk-changes-cost', 'SessionTypeController@bulkChangeCost')->name('session-types.bulk_changes_cost');
            Route::delete('session-types/bulk-delete', 'SessionTypeController@destroyMany')->name('session-types.bulk_delete');
            Route::resource('session-types', 'SessionTypeController')->except(['show']);
            /* speaker */
            Route::get('speakers/select2', 'SpeakerController@select2')->name('speakers.select2');
            Route::patch('speakers/bulk-changes-company', 'SpeakerController@bulkChangesCompany')->name('speakers.bulk_changes_company');
            Route::patch('speakers/bulk-changes-position', 'SpeakerController@bulkChangesPosition')->name('speakers.bulk_changes_position');
            Route::patch('speakers/bulk-changes-description', 'SpeakerController@bulkChangesDescription')->name('speakers.bulk_changes_description');
            Route::delete('speakers/bulk-delete', 'SpeakerController@destroyMany')->name('speakers.bulk_delete');
            Route::resource('speakers', 'SpeakerController')->except(['show']);

            /* partner */
            Route::post('partner/datatable', 'PartnerController@datatable')->name('partner.datatable');
            Route::resource('partners', 'PartnerController')->except(['show']);

            /* articles */
            Route::post('articles/datatable', 'ArticleController@datatable')->name('articles.datatable');
            Route::patch('article/update-status/{article}', 'ArticleController@updateStatus')->name('articles.update_status');
            Route::post('articles/set-feature', 'ArticleController@setFeature')->name('articles.set_feature');
            Route::resource('articles', 'ArticleController')->except(['show']);

            /* room capacity */
            Route::get('room-capacity', 'EventController@roomCapacity')->name('events.room_capacity');
            Route::post('room-capacity', 'EventController@roomCapacityData');
//            Route::resource('reports', 'ReportController');

            /* event report */
            Route::get('report', 'EventController@report')->name('events.report');
            Route::post('report', 'EventController@reportData');
            Route::post('attendee-registration-report', 'EventController@attendeeRegistrationReport')->name('events.attendee_registration_report');


        });
        /* room */
        Route::get('room/select2/{event}', 'RoomController@select2')->name('rooms.select2');
        Route::get('channels/select2/{event}', 'ChannelController@select2')->name('channels.select2');
        Route::resource('rooms', 'RoomController');

        /* ckfinder */
        Route::prefix('plugins')->group(function () {
            Route::get('ckfinder', 'CKFinderController@index');
            Route::any('ckfinder/connector', 'CKFinderController@connector');
        });
    });
});

