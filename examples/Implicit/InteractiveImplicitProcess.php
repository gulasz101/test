<?php

/**
 * you can serve this script locally easily with docker
 * just execute from root dir of this library line below
 *
 * docker run --rm -it -v $PWD:/var/www -w /var/www/examples/Implicit/ -p 7000:80 php php -S 0.0.0.0:80
 *
 * and in browser go to: http://localhost:7000/InteractiveImplicitProcess.php
 *
 */

declare(strict_types=1);

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

echo "<script>
            (function() {
                if (window.opener) {
                    let newOpenerLocation = window.opener.location.href += '?fromWindow=1';
                    window.location.hash.substr(1).split('&').forEach(
                        function (item) {
                            newOpenerLocation += '&' + item;                            
                        }
                    );
                    window.opener.location.href = newOpenerLocation;
                    window.close();
                }
            }())
            </script>
            ";

if (! \Illuminate\Support\Arr::get($_GET, 'fromWindow')) {
    $authorizationUrl = $provider->getAuthorizationUrl(array(
        'scope' => 'letter',
        'response_type' => 'token',
    ));

    // Redirect the user to the authorization URL.
    echo '<button onclick="window.open(\'' . $authorizationUrl . '\', \'\', \'width=972,height=660,modal=yes,alwaysRaised=yes\');">Obtain Authorization of user</button>';

    exit;
}
    try {
        $accessToken = \Illuminate\Support\Arr::get($_GET, 'access_token', function (): void {
            throw new Exception('Something went wrong, there is no access token');
        });

        echo '<pre>Token data</pre>';
        dump(
            array(
                'access_token' => $accessToken,
            )
        );
        echo '<pre>Letters fetched with new access token</pre>';
        dump(
            (new \Pingen\Endpoints\UserAssociationsEndpoint(
                $provider->setAccessTokenFromString($accessToken)
            ))
                ->getCollection()
        );
    } catch (\Throwable $e) {
        // Failed to get the access token or user details.
        exit($e->getMessage());
    }

?>
</body>
</html>
