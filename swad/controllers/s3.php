<?php
require_once '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;

class S3Uploader
{
    private $s3;

    public function __construct()
    {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => AWS_S3_REGION,
            'credentials' => [
                'key'    => AWS_S3_KEY,
                'secret' => AWS_S3_SECRET,
            ],
            'endpoint' => AWS_S3_ENDPOINT,
            'use_path_style_endpoint' => true,
        ]);
    }

    public function uploadFile($tmp_path, $destination)
    {
        try {
            $result = $this->s3->putObject([
                'Bucket' => AWS_S3_BUCKET_USERCONTENT,
                'Key'    => $destination,
                'Body'   => fopen($tmp_path, 'rb'),
                'ACL'    => 'public-read',
            ]);
            return $result->get('ObjectURL');
        } catch (S3Exception $e) {
            error_log("S3 Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteFile($url)
    {
        try {
            $key = parse_url($url, PHP_URL_PATH);
            $key = ltrim($key, '/');

            $this->s3->deleteObject([
                'Bucket' => AWS_S3_BUCKET_USERCONTENT,
                'Key'    => $key,
            ]);
            return true;
        } catch (S3Exception $e) {
            error_log("S3 Delete Error: " . $e->getMessage());
            return false;
        }
    }
}
