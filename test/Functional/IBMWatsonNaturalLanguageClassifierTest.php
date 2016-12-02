<?php

namespace Test\Functional;

require_once(__DIR__ . '/../../src/Models/checkRequest.php');

class IBMWatsonNaturalLanguageClassifierTest extends BaseTestCase {
    
    public function testCreateClassifier() {
        
        $var = '{  
                    "args":{  
                        "username":"564a30d7-759e-4ecd-8e5a-24a5ea124a39",
                        "password":"aWHsmcNBSeXI",
                        "trainingData":"https://github.com/watson-developer-cloud/doc-tutorial-downloads/raw/master/natural-language-classifier/weather_data_train.csv",
                        "language":"en",
                        "name":"new test"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/IBMWatsonNLC/createClassifier', $post_data);
        
        $classifierId = json_decode($response->getBody())->contextWrites->to->classifier_id;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
        return $classifierId;
        
    }
    
    public function testListClassifiers() {
        
        $var = '{  
                    "args":{  
                        "username":"564a30d7-759e-4ecd-8e5a-24a5ea124a39",
                        "password":"aWHsmcNBSeXI"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/IBMWatsonNLC/listClassifiers', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
    }
    
    /**
     * @depends testCreateClassifier
     */
    public function testGetClassifierInformation($classifierId) {
        
        $var = '{  
                    "args":{  
                        "username":"564a30d7-759e-4ecd-8e5a-24a5ea124a39",
                        "password":"aWHsmcNBSeXI",
                        "classifierId": "'.$classifierId.'"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/IBMWatsonNLC/getClassifierInformation', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
    }
    
    public function testClassify() {
        
        $var = '{  
                    "args":{  
                        "username":"564a30d7-759e-4ecd-8e5a-24a5ea124a39",
                        "password":"aWHsmcNBSeXI",
                        "classifierId": "8d6f49x128-nlc-1785",
                        "text": "How hot will it be today?"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/IBMWatsonNLC/classify', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
    }
    
    /**
     * @depends testCreateClassifier
     */
    public function testDeleteClassifier($classifierId) {
        
        $var = '{  
                    "args":{  
                        "username":"564a30d7-759e-4ecd-8e5a-24a5ea124a39",
                        "password":"aWHsmcNBSeXI",
                        "classifierId": "'.$classifierId.'"
                    }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/IBMWatsonNLC/deleteClassifier', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
    }
    
}
