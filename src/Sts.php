<?php
/**
 * Created by PhpStorm.
 * User: liul
 * Date: 10/23/18
 * Time: 14:17
 */

namespace Mogull\Aliyun\Sts;

use Sts\AssumeRoleRequest;
use Sts\Core\DefaultAcsClient;
use Sts\Core\Profile\DefaultProfile;

class Sts
{
    protected $endpointName;
    protected $regionId;
    protected $domain;
    protected $accessKeyId;
    protected $accessSecret;
    protected $roleArn;
    protected $policy;
    protected $clientName;
    protected $duration;

    /**
     * Sts constructor.
     * @param $endpointName
     * @param $regionId
     * @param $domain
     * @param $accessKeyId
     * @param $accessSecret
     * @param $roleArn
     * @param $policy
     * @param string $clientName
     * @param int $duration
     */
    public function __construct($endpointName, $regionId, $domain, $accessKeyId, $accessSecret, $roleArn, $policy, $clientName = '', $duration = config('aliyun_sts.expire_time'))
    {
        $this->endpointName = $endpointName;
        $this->regionId = $regionId;
        $this->domain = $domain;
        $this->accessKeyId = $accessKeyId;
        $this->accessSecret = $accessSecret;
        $this->roleArn = $roleArn;
        $this->policy = $policy;
        $this->clientName = $clientName;
        $this->duration = $duration;
    }

    /**
     * @return AssumeRoleRequest
     */
    public function createStsRequest()
    {
        $request = new AssumeRoleRequest();
        $request->setRoleSessionName($this->clientName);
        $request->setRoleArn($this->roleArn);
        $request->setPolicy($this->policy);
        $request->setDurationSeconds($this->duration);

        return $request;
    }

    /**
     * @return DefaultAcsClient
     */
    private function client()
    {
        DefaultProfile::addEndpoint($this->endpointName, $this->regionId, "Sts", $this->domain);
        $iClientProfile = DefaultProfile::getProfile($this->regionId, $this->accessKeyId, $this->accessSecret);
        $client = new DefaultAcsClient($iClientProfile);

        return $client;
    }

    /**
     * @param AssumeRoleRequest $request
     * @return mixed|\SimpleXMLElement
     */
    public function getResult($request)
    {
        return $this->client()->getAcsResponse($request);
    }

    /**
     * @param AssumeRoleRequest $request
     * @return null|\SimpleXMLElement[]
     */
    public function getCredentials($request)
    {
        $result = $this->getResult($request);
        return $result ? $result->Credentials : null;
    }
}