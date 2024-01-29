<?php

namespace App\Services;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Radek011200\CurlClientPhp\Curl;
use Radek011200\CurlClientPhp\Request\Header;
use Radek011200\CurlClientPhp\Request\Options;
use Illuminate\Http\Request;

class ApiService
{
    public Curl $curl;
    public Options $options;

    public function __construct()
    {
        $this->curl = new Curl();
        $this->options = new Options();

        $this->options
            ->addHeader(new Header('accept', 'application/json'))
            ->addHeader(new Header('api_key', 'asd123'));
    }

    /**
     * @param string $url
     * @return ResponseInterface
     * @throws Exception
     */
    public function makeGetRequest(string $url): ResponseInterface
    {
        return $this->curl->Get($url, $this->options);
    }

    /**
     * @param string $url
     * @param $body
     * @return ResponseInterface
     * @throws Exception
     */
    public function makePostRequest(string $url, $body): ResponseInterface
    {
        $this->options->addHeader(new Header('Content-Type', 'application/json'));

        return $this->curl->Post($url, $this->options, $body);
    }

    /**
     * @param string $url
     * @param $body
     * @return ResponseInterface
     * @throws Exception
     */
    public function makePutRequest(string $url, $body): ResponseInterface
    {
        $this->options->addHeader(new Header('Content-Type', 'application/json'));

        return $this->curl->Put($url, $this->options, $body);
    }

    /**
     * @param string $url
     * @return ResponseInterface
     * @throws Exception
     */
    public function makeDeleteRequest(string $url): ResponseInterface
    {
        return $this->curl->Delete($url, $this->options);
    }

    /**
     * @param Request $request
     * @param string $url
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function handleUploadImageRequest(Request $request, string $url): ResponseInterface
    {
        $petId = $request->input('petId');
        $additionalMetadata = $request->input('additionalMetadata');
        $file = $request->file('file');

        $client = new Client();

        return $client->post($url . $petId . '/uploadImage', [
            'multipart' => [
                [
                    'name'     => 'petId',
                    'contents' => $petId,
                ],
                [
                    'name'     => 'additionalMetadata',
                    'contents' => $additionalMetadata,
                ],
                [
                    'name'     => 'file',
                    'contents' => $file ? fopen($file->getRealPath(), 'r') : '',
                    'filename' => $file ? $file->getClientOriginalName() : '',
                ],
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }
}
