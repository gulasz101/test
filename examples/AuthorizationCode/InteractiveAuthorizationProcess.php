<?php

/**
 * you can serve this script locally easily with docker
 * just execute from root dir of this library line below
 *
 * docker run --rm -it -v $PWD:/var/www -w /var/www/examples/AuthorizationCode/ -p 7000:80 php php -S 0.0.0.0:80
 *
 * and in browser go to: http://localhost/InteractiveAuthorizationProcess:7000
 *
 */

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

/** @var \Pingen\Pingen $provider */
$provider = require 'provider.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Authorization code interactive example</title>
</head>
<body>

<?php
// If we don't have an authorization code then get one
if (! isset($_GET['code'])) {
    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).l
    $authorizationUrl = $provider->getAuthorizationUrl(array(
        'scope' => 'letter',
    ));

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
    echo '<button onclick="window.open(\'' . $authorizationUrl . '\', \'\', \'width=972,height=660,modal=yes,alwaysRaised=yes\');">Obtain Authorization of user</button>';

    exit;
// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
}
    if ($_GET['fromWindow'] === 1) {
        try {
            $accessToken = $provider->getAccessToken(
                'authorization_code',
                array(
                    'code' => $_GET['code'],
                )
            );

            echo '<pre>Token data</pre>';
            dump(
                array(
                    'access_token' => $accessToken->getToken(),
                    'refresh_token' => $accessToken->getRefreshToken(),
                )
            );
            echo '<pre>Letters fetched with new access token</pre>';
            dump(
                (new \Pingen\Endpoints\UserAssociationsEndpoint(
                    $provider->setAccessTokenFromString($accessToken->getToken())
                ))
                    ->getCollection()
            );
        } catch (\Throwable $e) {
            // Failed to get the access token or user details.
            exit($e->getMessage());
        }
    } else {
        echo "<script>
            (function() {
                if (window.opener) {
                    window.opener.location.href = window.document.location.href + '&fromWindow=1';
                    window.close();
                }
            }())
            </script>
            ";
        echo 'This should be closed by javascript';
    }

?>
</body>
</html>
