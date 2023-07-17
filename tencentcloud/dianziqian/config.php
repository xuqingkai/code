<php?
function config($key){
    //电子签企业ID
    $config['id']='';

    //电子签企业应用APPID
    $config['appid']='';

    //电子签加密key
    $config['key']='';

    //电子签授权token
    $config['token']='';

    //腾讯云secret_id
    $config['secret_id']='';

    //腾讯云secret_key
    $config['secret_key']='';
    return $config[$key];
}
