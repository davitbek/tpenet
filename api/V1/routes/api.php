<?php

Route::get('web/events/sports/{sport_id}/date/{date}', 'Enet\EnetEventController@eventsByDateSportForWeb');
Route::get('web/country-leagues/by-sport/{sport_id}/{date?}', 'Enet\EnetTournamentStageController@leaguesBySportCountryForWeb');
Route::get('web/auth/user/enet-leagues/favorite', 'Enet\EnetTournamentStageController@webUserFavoriteLeagues');


Route::get('main', 'ApiController@main');

Route::post('auth/register', 'AuthUserController@register');
Route::post('auth/activate', 'AuthUserController@activate');
Route::post('auth/login', 'AuthUserController@login');
Route::post('auth/login/refresh', 'AuthUserController@refreshToken');
//Route::post('auth/login-by-token', 'AuthUserController@login');
Route::post('auth/social-login', 'AuthUserController@socialLogin');
Route::post('auth/apple-login', 'AuthUserController@appleLogin');
Route::post('auth/password/forgot', 'AuthUserController@forgotPassword');
Route::post('auth/password/reset', 'AuthUserController@resetPassword');
Route::get('auth/user/enet-leagues/favorite', 'Enet\EnetTournamentStageController@userFavoriteLeagues');

/* Countries */
Route::get('countries', 'Enet\EnetCountryController@countriesIsoList'); // @TODO delete
Route::get('countries/list', 'Enet\EnetCountryController@countriesList');
Route::get('countries/all', 'Enet\EnetCountryController@all');
Route::get('countries/get', 'Enet\EnetCountryController@default');
Route::get('countries/default', 'Enet\EnetCountryController@default');
Route::get('countries/{id}', 'Enet\EnetCountryController@byId');
Route::get('countries/by-ip/{ip}', 'Enet\EnetCountryController@byIp');

/* Languages, Timezones*/
Route::get('languages','StaticController@allLanguages');
Route::get('languages/by-country/{id}', 'StaticController@languagesByCountry'); // TODO check
Route::get('timezones','StaticController@allTimezones');
Route::get('timezones/by-country/{id}','StaticController@timezonesByCountry'); // TODO check
Route::get('odd-types','StaticController@oddTypes');

Route::get('competitions', 'CompetitionController@index');
Route::get('competitions/{slug}', 'CompetitionController@showBySlug');

Route::get('app-versions/{version}', 'AppVersionController@show');
Route::get('betting-information', 'PageController@bettingInformation');

Route::get('iap', 'IapController@index');


Route::get('news', 'NewsController@index');
Route::get('news/{id}', 'NewsController@show');

Route::get('bookmakers', 'Enet\EnetOddsProviderController@index');
Route::get('bookmakers/{id}', 'Enet\EnetOddsProviderController@show');

Route::get('bookmaker-offers', 'AffiliateMediaController@index');
Route::get('bookmaker-offers/{id}', 'AffiliateMediaController@show');
Route::get('bookmaker-offers/ads/sport', 'AffiliateMediaController@sportAds');
Route::get('bookmaker-offers/ads/event', 'AffiliateMediaController@eventAds');
Route::get('bookmaker-offers/ads/event-mobile', 'AffiliateMediaController@eventMobileAds');


Route::get('users/{user_id}/followers', 'FollowController@followers');
Route::get('users/{user_id}/followings', 'FollowController@followings');
Route::get('users/suggest', 'UserController@suggest');
Route::get('users/suggest/{sport_readable_id}', 'UserController@suggest');

Route::get('users/{id}', 'UserController@show')->where('id', '[0-9]+');

Route::get('users/rank/month/this', 'UserController@thisMonthRank');
Route::get('users/rank/month/prev', 'UserController@prevMonthRank');
Route::get('users/rank/month/{month}', 'UserController@rankByMonth');


Route::get('users/{id}/statistics/monthly', 'UserTipStatisticController@userStatistics');


Route::get('users/{id}/tips', 'UserTipController@userTips');
Route::get('users/{id}/tips/ended', 'UserTipController@userEndedTips');
Route::get('users/{id}/tips/active', 'UserTipController@userActiveTips');
Route::get('users/{user_id}/followers/tips/active', 'UserTipController@userFollowersActiveTips')->where('user_id', '[0-9]+');
Route::get('users/{user_id}/followers/tips/ended', 'UserTipController@userFollowersEndedTips')->where('user_id', '[0-9]+');

Route::get('tips', 'UserTipController@index');
Route::get('tips/{id}', 'UserTipController@show');

Route::get('events/{event_id}/tips', 'UserTipController@eventTips');

Route::get('comments/{comment_id}/sub-comments', 'CommentController@subComments');
Route::get('comments/{commentable_type}/{commentable_id}', 'CommentController@commentsByType');
Route::get('tips/{tip_id}/comments', 'UserTipController@getComments');
Route::get('comments/{comment_id}/emotions/{emotion_id}/users', 'UserController@commentReactedUsers');

Route::get('emotions', 'EmotionController@index');
Route::get('tips/{tip_id}/emotions/{emotion_id}/users', 'UserController@tipReactedUsers');

Route::get('enet-sports', 'Enet\EnetSportController@activeSports');

Route::get('enet-leagues', 'Enet\EnetTournamentStageController@allLeagues');
Route::get('enet-leagues/{id}/standings/table', 'Enet\EnetTournamentStageController@tableStandings');
Route::get('enet-leagues/{id}/draw', 'Enet\EnetTournamentStageController@draw');
Route::get('enet-leagues/by-sport/{sport_id}/favorite/{date?}', 'Enet\EnetTournamentStageController@favoriteLeagues'); // TODO check
Route::get('enet-leagues/by-sport/{sport_id}/{date?}', 'Enet\EnetTournamentStageController@leaguesBySport'); // TODO check
Route::get('enet-country-leagues/by-sport/{sport_id}/{date?}', 'Enet\EnetTournamentStageController@leaguesBySportCountry'); // TODO check

Route::get('enet-events/feed', 'Enet\EnetEventController@feedEvents');
Route::get('enet-teams/feed', 'Enet\EnetParticipantController@feedTeams');
Route::get('enet-events/sports/{sport_id}/popular', 'Enet\EnetEventController@popularSportEvents'); // TODO check
Route::get('enet-events/sports/{sport_id}/date/{date}', 'Enet\EnetEventController@eventsByDateSport'); // TODO check when data is big have issue

Route::get('enet-events/leagues/{league_id}', 'Enet\EnetEventController@leagueEvents'); // TODO check
Route::get('enet-events/leagues/{league_id}/date/{date?}', 'Enet\EnetEventController@leagueEventsByDate'); // TODO check

Route::get('enet-events/{event_id}', 'Enet\EnetEventController@singeEvent');
Route::get('enet-events/{event_id}/outcome-types', 'Enet\EnetEventController@eventOutcomeTypes');
Route::get('enet-events/{event_id}/outcome-votes', 'Enet\EnetEventController@eventOutcomeVotes');
Route::get('enet-events/{event_id}/bookmakers/{outcome_type_id}', 'Enet\EnetEventController@eventBookmakersByOutcomeType'); // TODO check
Route::get('enet-events/{event_id}/odds/{outcome_type_id}', 'Enet\EnetEventController@eventOddsByOutcomeType'); // TODO check
Route::get('enet-events/{event_id}/bookmakers', 'Enet\EnetEventController@eventBookmakers');    // TODO delete  when data is big has some bug
Route::get('enet-events/{event_id}/odds', 'Enet\EnetEventController@eventOdds');                // TODO delete

Route::get('enet-events/{event_id}/results', 'Enet\EnetEventController@getEventResults');
Route::get('enet-events/{event_id}/overviews', 'Enet\EnetEventController@eventOverViews'); // TODO Delete
Route::get('enet-events/{event_id}/overviews-extended', 'Enet\EnetEventController@eventOverViewsExtended'); // TODO check
Route::get('enet-events/{event_id}/lineups', 'Enet\EnetEventController@eventLineups'); // TODO check
Route::get('enet-events/{event_id}/head-to-head', 'Enet\EnetEventController@eventHeadToHead'); // TODO check
Route::get('enet-events/{event_id}/tips', 'UserTipController@eventTips');
Route::get('enet-events/{event_id}/standings/participants', 'Enet\EnetEventController@eventParticipantStandings');
Route::get('enet-events/{event_id}/standings/teams', 'Enet\EnetEventController@eventTeamStandings');

Route::get('enet-events/{event_id}/head-to-head-extended', 'Enet\EnetEventController@eventHeadToHeadExtended');
Route::get('enet-events/{event_id}/home-team-events', 'Enet\EnetEventController@eventHomeTeamEvents');
Route::get('enet-events/{event_id}/away-team-events', 'Enet\EnetEventController@eventAwayTeamEvents');

Route::get('enet-teams', 'Enet\EnetParticipantController@teams');
Route::get('enet-teams/{team_id}', 'Enet\EnetParticipantController@team');
Route::get('enet-teams/{team_id}/last-events', 'Enet\EnetEventController@teamLastEvents');
Route::get('enet-teams/{team_id}/next-events', 'Enet\EnetEventController@teamNextEvents');
Route::get('enet-teams/{team_id}/participants', 'Enet\EnetParticipantController@teamParticipants');

Route::get('enet-athletes', 'Enet\EnetParticipantController@athletes');
Route::get('enet-athletes/{athlete_id}', 'Enet\EnetParticipantController@athlete');
Route::get('enet-athletes/{athlete_id}/teams', 'Enet\EnetParticipantController@athleteTeams'); // not correct need check  enet-teams/257/participants check reverse
Route::get('enet-athletes/{athlete_id}/last-events', 'Enet\EnetEventController@athleteLastEvents');
Route::get('enet-athletes/{athlete_id}/next-events', 'Enet\EnetEventController@athleteNextEvents');

Route::get('enet-participants', 'Enet\EnetParticipantController@athletes');
Route::get('enet-participants/{participants_id}', 'Enet\EnetParticipantController@athlete');
Route::get('enet-participants/{participants_id}/teams', 'Enet\EnetParticipantController@athleteTeams'); // not correct need check  enet-teams/257/participants check reverse


Route::get('enet-participants/{participants_id}/last-events', 'Enet\EnetEventController@athleteLastEvents');
Route::get('enet-participants/{participants_id}/next-events', 'Enet\EnetEventController@athleteNextEvents');

Route::get('/betting-dictionary', 'BettingDictionaryController@all');
Route::get('/betting-dictionary/{slug}', 'BettingDictionaryController@bySlug');
Route::post('/mails/contact', 'MailController@sendContactMessage');

Route::get('/betting-offers/{id}', 'Enet\EnetBettingOfferController@show');

//Route::get('enet-tournament-templates', 'Enet\EnetTournamentTemplateController@index');
//Route::get('enet-tournament-templates/{id}', 'Enet\EnetTournamentTemplateController@show');
//
//Route::get('enet-tournament-stages', 'Enet\EnetTournamentStageController@index');
//Route::get('enet-tournament-stages/{id}', 'Enet\EnetTournamentStageController@show');
//Route::get('enet-tournament-stages/sport/{sport_id}/date/{date}', 'Enet\EnetTournamentStageController@indexBySportByDate');
//
//Route::get('enet-participants/{type}/{participant_id}', 'EnetParticipantController@showByType');

Route::post('odds-tools/calculate', 'ApiController@calculateOdds');

Route::get('enet-events', 'Enet\EnetEventController@index');

Route::get('seo', 'SeoController@getSeoList');

Route::middleware(\Api\V1\Http\Middleware\ApiAuth::class)->group(function () {
// @TODO make route aliases
    // TODO  delete auth/user/
    Route::get('auth/user', 'AuthUserController@getAuthUser');
    Route::get('users/auth', 'AuthUserController@getAuthUser');

    Route::put('auth/user/update', 'AuthUserController@updateAuth');
    Route::put('users/auth/update', 'AuthUserController@updateAuth');

    Route::put('auth/user/update/feedback-rating', 'AuthUserController@updateAuthFeedbackRating');
    Route::put('users/auth/update/feedback-rating', 'AuthUserController@updateAuthFeedbackRating');

    Route::put('auth/user/update/password', 'AuthUserController@updateAuthPassword');
    Route::put('users/auth/update/password', 'AuthUserController@updateAuthPassword');

    Route::put('auth/user/update/notification-token', 'AuthUserController@updateAuthNotificationToken');
    Route::put('users/auth/update/notification-token', 'AuthUserController@updateAuthNotificationToken');

    Route::put('users/auth/update/settings/{id}', 'AuthUserController@updateSetting');
    Route::put('users/auth/update/mass-settings', 'AuthUserController@updateManySettings');

    Route::put('auth/user/update/notification-settings', 'AuthUserController@updateAuthNotificationSettings');
    Route::put('users/auth/update/notification-settings', 'AuthUserController@updateAuthNotificationSettings');

    Route::put('auth/user/update/email-settings', 'AuthUserController@updateAuthEmailSettings');
    Route::put('users/auth/update/email-settings', 'AuthUserController@updateAuthEmailSettings');

    Route::put('auth/user/update/profile-settings', 'AuthUserController@updateAuthProfileSettings');
    Route::put('users/auth/update/profile-settings', 'AuthUserController@updateAuthProfileSettings');

    Route::post('auth/user/update/profile-picture', 'AuthUserController@updateAuthProfilePicture');
    Route::post('users/auth/update/profile-picture', 'AuthUserController@updateAuthProfilePicture');

    Route::delete('auth/user/delete', 'AuthUserController@deleteAuth');
    Route::delete('users/auth/delete', 'AuthUserController@deleteAuth');

    Route::get('auth/user/notifications', 'NotificationController@authNotifications');
    Route::get('users/auth/notifications', 'NotificationController@authNotifications');
    Route::get('users/auth/notifications/unread/count', 'NotificationController@getAuthUnreadNotificationsCount');
    Route::get('users/auth/news/unread/count', 'NewsController@getAuthUnreadNewsCount');

    Route::put('users/auth/notifications/make-all-as-read', 'NotificationController@makeAllAsRead');
    Route::put('users/auth/notifications/{id}/change-read', 'NotificationController@changeRead');
    Route::put('users/auth/news/make-all-as-read', 'NewsController@makeAllAsRead');

    Route::get('users/auth/followers/tips/active', 'UserTipController@authFollowerActiveTips');
    Route::get('auth/user/followers/tips/active', 'UserTipController@authFollowerActiveTips');

    Route::get('users/auth/followers/tips/ended', 'UserTipController@authFollowerEndedTips');
    Route::get('auth/user/followers/tips/ended', 'UserTipController@authFollowerEndedTips');

    Route::get('users/auth/position/rank/month/this', 'UserController@thisMonthPosition');
    Route::get('auth/user/position/rank/month/this', 'UserController@thisMonthPosition');

    Route::get('users/auth/position/rank/month/prev', 'UserController@prevMonthPosition');
    Route::get('auth/user/position/rank/month/prev', 'UserController@prevMonthPosition');

    Route::get('users/auth/position/rank/month/{month}', 'UserController@positionByMonth');
    Route::get('auth/user/position/rank/month/{month}', 'UserController@positionByMonth');

    Route::post('purchase', 'PurchaseController@store');
    Route::post('users/{id}/follow', 'FollowController@followUnFollow');

    Route::post('comments', 'CommentController@store');
    Route::post('comments/{comment_id}/sub-comments', 'CommentController@storeSubComment');
    Route::put('comments/{comment_id}/update', 'CommentController@update');
    Route::delete('comments/{comment_id}', 'CommentController@destroy');
    Route::post('tips/{tip_id}/comments', 'UserTipController@storeComment'); //TODO tips is invalid

//
//    Route::post('user/leagues/{league_id}/add-favorite', 'Api\UserController@makeLegionAsFavorite');
//    Route::post('user/leagues/{league_id}/remove-favorite', 'Api\UserController@removeFavoriteLeague');
//    Route::post('user/leagues/by-sport/{sport_id}/favorite', 'Api\UserController@favoriteLeagues');

    Route::post('tips', 'UserTipController@store');

    Route::post('enet-tips', 'UserTipController@storeEnetTips');

    Route::post('emotions/{emotion_id}/{type}/{relatedId}', 'EmotionController@assignItemToEmotion');
    Route::delete('emotions/{emotion_id}/{type}/{relatedId}', 'EmotionController@unassignItemFromEmotion');

    Route::post('tips/{tip_id}/emotions/{emotion_id}', 'UserTipController@assignEmotionToItem');
    Route::delete('tips/{tip_id}/emotions/{emotion_id}', 'UserTipController@unassignEmotionFromItem');

    Route::post('comments/{comment_id}/emotions/{emotion_id}', 'CommentController@assignEmotionToItem');
    Route::delete('comments/{comment_id}/emotions/{emotion_id}', 'CommentController@unassignEmotionFromItem');

    Route::post('enet-events/{id}/favorite', 'Enet\EnetEventController@favoriteUnFavorite');
    Route::post('enet-events/favorites/{id}/enable', 'Enet\EnetEventController@enableUnenableFavoriteEvent');
    Route::get('auth/user/enet-events/favorite/counts', 'Enet\EnetEventController@userFavoriteEventCount');
    Route::get('auth/user/enet-events/favorite/{time}', 'Enet\EnetEventController@userFavoriteEvents');

    Route::get('users/auth/enet-leagues', 'Enet\EnetTournamentStageController@userLeagues');
    Route::post('enet-leagues/{id}/favorite', 'Enet\EnetTournamentStageController@favoriteUnFavorite');
    Route::post('enet-leagues/initial-favorite', 'Enet\EnetTournamentStageController@makeInitialFavorite');
    Route::post('enet-leagues/mass-favorite', 'Enet\EnetTournamentStageController@massFavoriteUnFavorite');

    Route::get('users/auth/enet-teams', 'Enet\EnetParticipantController@userTeams');
    Route::post('enet-teams/{id}/favorite', 'Enet\EnetParticipantController@favoriteUnFavorite');
    Route::post('enet-teams/mass-favorite', 'Enet\EnetParticipantController@massFavoriteUnFavorite');

    Route::post('enet-events/{event_id}/outcome-votes/{vote_id}/{key}', 'Enet\EnetEventController@storeEventOutcomeVote');

});
