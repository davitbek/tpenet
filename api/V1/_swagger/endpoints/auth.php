<?php
/**
 *@OA\Post(
 *     path="/auth/register",
 *     tags={"Auth"},
 *     summary="Register new User",
 *     description="Create new user. New user is not active. Application send email providing code. Using that code can activate user",
 *     @OA\Parameter(
 *          name="name",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password_confirmation",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="country",
 *          description=" depricated. must be remove (old: <strong>Now need use country_id</strong>)",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="country_id",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="lang",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="get_access_tokens",
 *          in="query",
 *          description="for get access tokens",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  ref="$/components/schemas/User",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *
 *     @OA\Response(
 *          response=401,
 *          description="Validation error",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="string",
 *                  example="null"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  ref="$/components/schemas/ValidationError",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *
 *@OA\Post(
 *     path="/auth/login",
 *     tags={"Auth"},
 *     summary="Login New User",
 *     @OA\Parameter(
 *          name="email",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="remember_me",
 *          description="When remember_me is true access_token is active 1 month",
 *          in="query",
 *          @OA\Schema(
 *              type="boolean"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="remember_days",
 *          description="When remember_days is integer and must active due this days",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="force_login",
 *          in="query",
 *          required=false,
 *          description="User force login without checking user already activated or not",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="object",
 *                  @OA\Property(
 *                      property="user",
 *                      ref="$/components/schemas/User",
 *                  ),
 *                  @OA\Property(
 *                      property="tokens",
 *                      ref="$/components/schemas/Tokens",
 *                  ),
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="Validation error",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="string",
 *                  example="null"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  ref="$/components/schemas/ValidationError",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *
 *@OA\Post(
 *     path="/auth/social-login",
 *     tags={"Auth"},
 *     summary="Login(register) New User by facebook",
 *     @OA\Parameter(
 *          name="id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="first_name",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="last_name",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="url",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="remember_me",
 *          description="When remember_me is true access_token is active 1 month",
 *          in="query",
 *          @OA\Schema(
 *              type="boolean"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="remember_days",
 *          description="When remember_days is integer and must active due this days",
 *          in="query",
 *          @OA\Schema(
 *              type="integer"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="object",
 *                  @OA\Property(
 *                      property="user",
 *                      ref="$/components/schemas/User",
 *                  ),
 *                  @OA\Property(
 *                      property="tokens",
 *                      ref="$/components/schemas/Tokens",
 *                  ),
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="Validation error",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="string",
 *                  example="null"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  ref="$/components/schemas/ValidationError",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Get(
 *     path="/auth/user",
 *     tags={"Auth", "User"},
 *     summary="Retrive logged user",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="object",
 *                  ref="$/components/schemas/User",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="Validation error",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="string",
 *                  example="null"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  ref="$/components/schemas/GeneralError",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *
 *@OA\Delete(
 *     path="/auth/user/delete",
 *     tags={"Auth", "User"},
 *     summary="delete auth user",
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="object",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *              )
 *          )
 *     ),
 * )
 *
 *
 *@OA\Post(
 *     path="/auth/login/refresh",
 *     tags={"Auth"},
 *     summary="refresh login accesd_token",
 *     @OA\Parameter(
 *          name="refresh_token",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  ref="$/components/schemas/Tokens",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="null"
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="Validation error",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *                  type="string",
 *                  example="null"
 *              ),
 *              @OA\Property(
 *                  property="error",
 *                  ref="$/components/schemas/ValidationError",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Post(
 *     path="/auth/activate",
 *     tags={"Auth"},
 *     summary="Login(register) New User by facebook",
 *     @OA\Parameter(
 *          name="user_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="code",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Post(
 *     path="/auth/password/forgot",
 *     tags={"Auth"},
 *     summary="send reset password email",
 *     @OA\Parameter(
 *          name="email",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Post(
 *     path="/auth/password/reset",
 *     tags={"Auth"},
 *     summary="send reset password email",
 *     @OA\Parameter(
 *          name="email",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="token",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password_confirmation",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Put(
 *     path="/auth/user/update",
 *     tags={"Auth"},
 *     summary="update auth data",
 *     @OA\Parameter(
 *          name="current_password",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="feedback_rating",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password_confirmation",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="odds_type",
 *          description="change odds_typ 2 means fraction, 1 means decimal",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="one_token",
 *          description=" depricated. must be remove (old: <del>set android, ios notification token</del>)",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="android_one_token",
 *          description="set android one token",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="ios_one_token",
 *          description="set ios one token",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="name",
 *          description="name",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email",
 *          description="set android, ios notification user tip",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *              format="email",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="phone",
 *          description="phone number",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="bio",
 *          description="bio",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="avatar",
 *          description="profile avatar",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="one_token",
 *          description=" depricated. must be remove (old: <del>set android, ios notification token</del>)",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="android_one_token",
 *          description="set android one token",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="ios_one_token",
 *          description="set ios one token",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="noti_sys",
 *          description="set android, ios notification setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="noti_user_tip",
 *          description="set android, ios notification user tip",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="noti_tip_ended",
 *          description="set android, ios notification tip ended",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="noti_live",
 *          description="set android, ios notification live",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="birthday",
 *          description="set android, ios notification live",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *              format="date",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="country",
 *          description=" depricated. must be remove (old: <strong>Now need use country_id</strong>)",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="country_id",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_news_product_update",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_news_tipya_partner",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_suggestions_recommended_accounts",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_research_surveys",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_top_tips_matches",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_offers",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_new_follower",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_new_notification",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_tip_ended",
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Put(
 *     path="/auth/user/update/password",
 *     tags={"Auth"},
 *     summary="update auth password",
 *     @OA\Parameter(
 *          name="current_password",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="password_confirmation",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Put(
 *     path="/users/auth/update/settings/{setting_id}",
 *     tags={"Auth"},
 *     summary="update user email or notifcation setting id",
 *     @OA\Parameter(
 *          name="setting_id",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *          ),
 *          description="Id of notification settings, income in auth response email_settings_extended or notification_settings_extended data"
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Put(
 *     path="/users/auth/update/mass-settings",
 *     tags={"Auth"},
 *     summary="update user email or notifcation setting id",
 *     @OA\Parameter(
 *          name="ids",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="array",
 *              @OA\Items(
 *                  type="integer",
 *              ),
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Put(
 *     path="/auth/user/update/feedback-rating",
 *     tags={"Auth"},
 *     summary="update auth feedback rating",
 *     @OA\Parameter(
 *          name="feedback_rating",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Put(
 *     path="/users/auth/update/feedback-rating",
 *     tags={"Auth"},
 *     summary="update auth feedback rating",
 *     @OA\Parameter(
 *          name="feedback_rating",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Put(
 *     path="/auth/user/update/notification-token",
 *     tags={"Auth", "Notification"},
 *     summary="update auth password",
 *     @OA\Parameter(
 *          name="one_token",
 *          description=" depricated. must be remove (old: <del>set android, ios notification token</del>)",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="android_one_token",
 *          description="set android one token",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="ios_one_token",
 *          description="set ios one token",
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Put(
 *     path="/auth/user/update/notification-settings",
 *     tags={"Auth", "Notification"},
 *     summary="update auth password",
 *     @OA\Parameter(
 *          name="noti_sys",
 *          required=true,
 *          description="set android, ios notification setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="noti_user_tip",
 *          required=true,
 *          description="set android, ios notification user tip",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="noti_tip_ended",
 *          required=true,
 *          description="set android, ios notification tip ended",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="noti_live",
 *          required=true,
 *          description="set android, ios notification live",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="follow",
 *          required=true,
 *          description="you got a new follower",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 * @OA\Put(
 *     path="/auth/user/update/email-settings",
 *     tags={"Auth", "Notification"},
 *     summary="update auth password",
 *     @OA\Parameter(
 *          name="email_news_product_update",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_news_tipya_partner",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_suggestions_recommended_accounts",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_research_surveys",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_top_tips_matches",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_offers",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_new_follower",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_new_notification",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email_tip_ended",
 *          required=true,
 *          description="set android, ios email setting",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *              enum={0, 1},
 *          ),
 *     ),
 *
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *@OA\Put(
 *     path="/auth/user/update/profile-settings",
 *     tags={"Auth", "Notification"},
 *     summary="update auth password",
 *     @OA\Parameter(
 *          name="name",
 *          description="name",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="email",
 *          description="set android, ios notification user tip",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *              format="email",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="phone",
 *          description="phone number",
 *          in="query",
 *          @OA\Schema(
 *              type="integer",
 *          ),
 *     ),
 *     @OA\Parameter(
 *          name="bio",
 *          description="bio",
 *          in="query",
 *          @OA\Schema(
 *              type="string",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 *@OA\Post(
 *     path="/auth/user/update/profile-picture",
 *     tags={"Auth", "Notification"},
 *     summary="update auth password",
 *     @OA\Parameter(
 *          name="avatar",
 *          description="profile avatar",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="file",
 *          ),
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Example extended response",
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="result",
 *              ),
 *              @OA\Property(
 *                  property="error",
 *              )
 *          )
 *     ),
 *     security={{"Bearer":{}}}
 * )
 *
 */