<?php 
#### Argument Parsers:
/*
 * Test scripts
 * php advise.php -r "ap-southeast-1" -s "rds,ec2" -d false -l here.json
 * php advise.php -r "ap-southeast-1"
 * php advise.php -s "rds,ec2"
 * php advise.php --region "ap-southeast-1" --services "rds,ec2" --debug true --log sample/here.json
 */
class ArguParser{
    const OPTLISTS = [
        "r" => "region",
        "s" => "services",
        "l" => "log",
        "d" => "debug",
        "t" => "test"
    ];
    
    static function Load(){
        $options = self::validate(self::__arguParser());
        return $options;
    }
    
    static function __arguParser(){
        $shortOps = '';
        $longOps = [];
        
        foreach(self::OPTLISTS as $shortOp => $longOp){
            $separator = ":";
            $shortOps .= ($shortOp . $separator);
            $longOps[] = ($longOp . $separator);
        }
        
        $options = getopt($shortOps, $longOps);
        return $options;
    }
    
    static function validate($options){
        foreach(Config::CLI_ARGUMENT_RULES as $param => $rules){
            if( isset($rules['required']) 
                && $rules['required'] 
                && empty($options[$param])
            ){
                $msg = $rules['errmsg'] ?? "Missing <--$param>";
                exit($msg . PHP_EOL);
            }
            
            if( isset($rules['default']) && empty($options[$param])){
                $defaultValue = $rules['default'];
                if ( isset($rules['emptymsg']) ){
                    eval('$emptyMsg = "' . $rules['emptymsg'] . '";');
                    echo "[Info]: " . $emptyMsg . PHP_EOL;
                }
                $options[$param] = $defaultValue;
            }
        }
        
        return $options;
    }
}