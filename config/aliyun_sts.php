<?php
return [
    'endpoint'    => env('ALIYUN_ENDPOINT', 'cn-beijing'),
    'region'      => env('ALIYUN_REGION', 'cn-beijing'),
    'domain'      => env('ALIYUN_DOMAIN', 'sts.cn-beijing.aliyuncs.com'),
    'key'         => env('ALIYUN_STS_KEY', 'ALIYUN_STS_KEY'),
    'secret'      => env('ALIYUN_STS_SECRET', 'ALIYUN_STS_SECRET'),
    'role_arn'    => env('ALIYUN_STS_ROLE_ARN', 'ALIYUN_STS_ROLE_ARN'),
    'expire_time' => env('ALIYUN_STS_EXPIRE_TIME', 900),
    'policy'      => <<<POLICY
        {
          "Statement": [
            {
              "Action": [
                "oss:*"
              ],
              "Effect": "Allow",
              "Resource": ["acs:oss:*:*:*"]
            }
          ],
          "Version": "1"
        }
POLICY

];
