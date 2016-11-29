<?php

$app->post('/api/IBMWatsonNaturalLanguageClassifier/createClassifier', function ($request, $response, $args) {
    
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['username','password','trainingData','language']);
    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    
    $auth = [$post_data['args']['username'], $post_data['args']['password']];
    
    $data['name'] = 'training_data';
    $data['contents'] = fopen($post_data['args']['trainingData'], 'r');
    $body[] = $data;
    
    if(!empty($post_data['args']['name'])) {
        $meta = '{"language":"'.$post_data['args']['language'].'","name":"'.$post_data['args']['name'].'"}';
    } else {
        $meta = '{"language":"'.$post_data['args']['language'].'"}';
    }    
    $metadata['name'] = 'training_metadata';
    $metadata['contents'] = $meta;
    $body[] = $metadata;
     
   
    $query_str = 'https://gateway.watsonplatform.net/natural-language-classifier/api/v1/classifiers';
    
    $client = $this->httpClient;
    
    try {

        $resp = $client->post( $query_str, 
            [
                'multipart' => $body,
                'auth' => $auth
            ]
        );
        $responseBody = $resp->getBody()->getContents();
  
        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
            if(empty($result['contextWrites']['to'])) {
                $result['contextWrites']['to']['status_msg'] = "Api return no results";
            }
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();        
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        if($exception->getResponse()->getStatusCode()=='415') {
            $out = 'Unsupported Media Type';
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ConnectException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';

    }
    
    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    
});
