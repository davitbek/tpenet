import SessionService from './session';

/**
 * Save session
 *
 * @param access_token
 * @param expires_in
 * @param refresh_token
 * @param remember
 */
export const saveSession = ({ access_token, expires_in, refresh_token }, remember) => {
    const expires = new Date(new Date().getTime() + expires_in * 1000);

    const options = {
        path: '/',
        expires: expires
    };

    SessionService.set('token', access_token, options);
    SessionService.set('tokenExpiresAt', options.expires, options);

    if (remember) {
        const rememberExpires = new Date(new Date().getTime() + (expires_in + 2500000) * 1000);
        const rememberOptions = {
            path: '/',
            expires: rememberExpires
        };

        SessionService.set('refreshToken', refresh_token, rememberOptions);
    }
};

/**
 * Destroy session
 */
export const destroySession = () => {
    const options = {
        path: '/'
    };

    SessionService.remove('token', options);
    SessionService.remove('tokenExpiresAt', options);
    SessionService.remove('refreshToken', options);
};
