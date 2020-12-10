<?php

if (!function_exists('json_encode')) {
	throw new Exception('TruSuggest needs the JSON PHP extension.');
}

class TruSuggest {

    const ENDPOINT = "https://api.trusuggest.com/dev/index";

	public static function upload($accessToken, $indexName, $data) {
        $endpoint = TruSuggest::ENDPOINT . "/upload";

        $requestData = array(
            "uploadData" => $data,
            "indexName" => $indexName
        );

        $headers = array(sprintf('Authorization: Bearer %s', $accessToken));
		return TruSuggest::_send($endpoint, $requestData, $headers);
    }
    
    public static function bulkUpload($accessToken, $indexName, $data) {
        $endpoint = TruSuggest::ENDPOINT . "/bulk-upload";

        $requestData = array(
            "uploadData" => $data,
            "indexName" => $indexName
        );

        $headers = array(sprintf('Authorization: Bearer %s', $accessToken));
		return TruSuggest::_send($endpoint, $requestData, $headers);
    }


    private static function _send($endpoint, $requestData, $headers) {
		$requestData = json_encode($requestData);

		$headers  = array_merge($headers, array('Accept: application/json', 'Content-Type: application/json'));

		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $endpoint);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $requestData);

		$result = curl_exec($handle);
        $code   = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);

		return $result;
	}

}

?>