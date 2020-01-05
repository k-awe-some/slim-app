<?php
namespace Chatter\Middlewares;

class FileFilter
{
    protected $allowedFiles = ['image/jpeg', 'image/png'];

    public function __invoke($request, $response, $next)
    {
        $files = $request->getUploadedFiles();
        $newfile = $files['file'];
        $newfile_type = $newfile->getClientMediaType();

        if (!in_array($newfile_type, $this->allowedFiles)) {
            return $response->withStatus(415); // unsupported media type
        }

        $response = $next($request, $response);
        return $response;
    }
}
