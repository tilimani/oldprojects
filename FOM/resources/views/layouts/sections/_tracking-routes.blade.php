{{-- Here you will find all the current VICO pages that are being tracked with SEGMENT --}}
@if (Route::currentRouteName() == 'home')

    analytics.page('homePage-Medellin');

@elseif (Route::currentRouteName() == 'landingpage.bogota')

    analytics.page('homePage-Bogota');

@elseif (Route::currentRouteName() == 'questions.user')

    analytics.page('FAQ users');

@elseif (Route::currentRouteName() == 'questions.host')

    analytics.page('FAQ hosts');

@elseif (Route::currentRouteName() == 'home.about')

    analytics.page('About VICO');

@elseif (Route::currentRouteName() == 'favorites')

    analytics.page('Favorites');

@elseif (Route::currentRouteName() == 'vico.process')

    analytics.page('Booking Notifications');

@elseif (Route::currentRouteName() == 'introduction')

    analytics.page('Upload VICO introdcution');

@elseif (Route::currentRouteName() == 'create')

    analytics.page('Upload VICO step 1 (Begin)');

@elseif (Route::currentRouteName() == 'create_house')

    analytics.page('Upload VICO step 2 (Finish the house info)');

@elseif (Route::currentRouteName() == 'house.finish')

    analytics.page('Upload VICO step 4 (House finished)');

@elseif (Route::currentRouteName() == 'my_verifications')

    analytics.page('Verifications page');

@elseif (Route::currentRouteName() == 'show_house')

    analytics.page('Houses show view');

@else
    analytics.page();
@endif
