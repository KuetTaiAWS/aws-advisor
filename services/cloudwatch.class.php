<?php
use Aws\CloudWatch\CloudWatchClient;
use Aws\CloudWatch\Exception;

class cloudwatch{
    function __construct($region){
        global $CONFIG; 
        
        $this->__AWS_OPTIONS = $CONFIG->get("__AWS_OPTIONS");
        $this->__AWS_OPTIONS['region'] = $region;
        $this->__AWS_OPTIONS['version'] = CONFIG::AWS_SDK['CLOUDWATCHCLIENT_VERS'];
        
        $this->cwClient = new CloudWatchClient($this->__AWS_OPTIONS);
    }
    
    function getClient(){
        return $this->cwClient;   
    }
    
    function test(){
        // $resp = $this->cwClient->listMetrics([
        //     'Dimensions' => [
        //         [
        //             'Name' => 'DBInstanceIdentifier',
        //             'Value' => 'postgres-13'
        //         ]
        //     ],
        //     'Namespace' => 'AWS/RDS',
        //     'MetricName' => 'CPUUtilization'
        // ]);
        
        // __pr($resp);
        
        # return;
        
        
        $metric = 'FreeStorageSpace';
        $results = $this->cwClient->getMetricStatistics([
            'Dimensions' => [
                [
                    'Name' => 'DBInstanceIdentifier',
                    'Value' => 'postgres-13'
                ]
            ],
            'Namespace' => 'AWS/RDS',
            'MetricName' => $metric,
            'StartTime' => strtotime('-5 minutes'),
            'EndTime' => strtotime('now'),
            'Period' => 300,
            'Statistics' => ['Average'],
            #'Unit' => 'None'
        ]);   
        
        __pr($results);
    }
}