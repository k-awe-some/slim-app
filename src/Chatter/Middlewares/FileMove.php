<?php
namespace Chatter\Middlewares;

use Aws\S3\S3Client;

class FileMove
{
    public function __invoke($request, $response, $next)
    {
        $s3 = new S3Client([
          'version' => 'latest',
          'region' => 'us-est-2'
        ]);
        $files = $request->getUploadedFiles();
        $newfile = $files['file'];
        $uploadFilename = $newfile->getClientFilename();
        $png = 'assets/images/' . substr($uploadFilename, 0, -4) . '.png';

        try {
            $s3->putObject([
            'Bucket' => 'slim-app',
            'Key' => 'some-key',
            'Body' => fopen($pngfile, 'w'),
            'ACL' => 'public-read'
          ]);
        } catch (Exception $exc) {
            return $response->withStatus(400);
        }

        $response = $next($request, $response);

        return $response;
    }
}
