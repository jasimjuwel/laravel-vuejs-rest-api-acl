<?php

namespace App\Http\Controllers\SoapApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artisaninweb\SoapWrapper\SoapWrapper;
use SoapClient;
use SoapHeader;

class SoapController extends Controller
{

    public function CheckHoliday()
    {

        //Create the client object
        $soapclient = new SoapClient('http://holidaywebservice.com/HolidayService_v2/HolidayService2.asmx?WSDL', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);

        //Use the functions of the client, the params of the function are in
        //the associative array
        $params = array('Code' => 'Spain', 'Description' => 'Alicante');
        $response = $soapclient->GetCountriesAvailable($params);

        dd($response);

        // Get the Cities By Country
        $param = array('Code' => 'Spain');
        $response = $soapclient->GetCountriesAvailable($param);

        dd($response);
    }

    public function getCapitalCitys(){
        //Create the client object
        $soapclient = new SoapClient('http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);

        //Use the functions of the client, the params of the function are in
        //the associative array
        $params = array('sCountryISOCode' => 'IN');
        $response = $soapclient->CapitalCity($params);

        dd($response);
    }

    public function getWeather(){
        $requestParams = array(
            'CityName' => 'Berlin',
            'CountryName' => 'Germany'
        );

        $client = new SoapClient('http://www.webservicex.net/globalweather.asmx?WSDL', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);
        $response = $client->GetWeather($requestParams);

        dd($response);
    }

    public function getIP(){
        $client = new SoapClient('http://read.pudn.com/downloads74/sourcecode/windows/other/267115/GeoIPSerApplication/Web%20References/GeoIPService/geoipservice.wsdl__.htm', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);
        $result = $client->GetGeoIP(array('IPAddress' => '8.8.8.8'));

        dd($result);
    }

    public function checkVat()
    {
        try {
            $opts = array(
                'http' => array(
                    'user_agent' => 'PHPSoapClient'
                )
            );
            $context = stream_context_create($opts);

            $wsdlUrl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
            $soapClientOptions = array(
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE
            );

            $client = new SoapClient($wsdlUrl, $soapClientOptions);

            $checkVatParameters = array(
                'countryCode' => 'DK',
                'vatNumber' => '47458714'
            );

            $result = $client->checkVat($checkVatParameters);
            dd($result);
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function test()
    {
        $apiauth = array('UserName' => 'username', 'Password' => 'password');
        $wsdl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

        $soap = new SoapClient($wsdl);
        $header = new SoapHeader('http://tempuri.org/', 'AuthHeader', $apiauth);
        $soap->__setSoapHeaders($header);
        $data = $soap->mymethodname($my_method_parameter, $header);

        print_r($data);

    }
}
