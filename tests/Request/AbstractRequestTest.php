<?php


class AbstractRequestTest extends PHPUnit_Framework_TestCase {
    const METHOD = "testMethod";
    const ID     = "testId";

    const PARAM_KEY_1 = "testKey1";
    const PARAM_KEY_2 = "testKey2";

    const PARAM_VALUE_1 = "paramValue1";
    const PARAM_VALUE_2 = "paramValue2";

    public function testToJsonMethod() {
        $request = $this->getMockForAbstractClass(
            'Barrister\Request\AbstractRequest',
            array(
                \Barrister\Request\AbstractRequest::METHOD => self::METHOD,
                \Barrister\Request\AbstractRequest::PARAMS => array()
            )
        );

        $jsonEncodedString = $request->toJson();

        $decodedJson = json_decode($jsonEncodedString);

        $this->assertEquals(self::METHOD, $decodedJson->method);
    }

    public function testToJsonParams() {
        $request = $this->getMockForAbstractClass(
            'Barrister\Request\AbstractRequest',
            array(
                \Barrister\Request\AbstractRequest::METHOD => self::METHOD,
                \Barrister\Request\AbstractRequest::PARAMS => array(
                    self::PARAM_KEY_1 => self::PARAM_VALUE_1,
                    self::PARAM_KEY_2 => self::PARAM_VALUE_2
                )
            )
        );

        $jsonEncodedString = $request->toJson();

        $decodedJson = json_decode($jsonEncodedString);

        $params = $decodedJson->params;

        $this->assertEquals(self::PARAM_VALUE_1, $params->testKey1);
        $this->assertEquals(self::PARAM_VALUE_2, $params->testKey2);
    }
}
