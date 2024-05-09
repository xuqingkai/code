function caiji(){
    $result='';
    $root = 'https://www.example.com';
    $all = intval('0'.input('get.all'));//默认0,只采集新数据
    $page = intval('0'.input('get.page')); if($page<1){$page=1;}
    $str = file_get_contents('http://xg.52xa.xyz/index/cj/paging.html?pg='.$page);
    $json = json_decode($str,true);
    $total=0;
    foreach($json as $key=>$item){
        $img_path='';
        $thumbsave = '../public/uploads/'.$item['indexs'].'/'.$item['id'].'/thumb/';
        if(!is_dir($thumbsave)){ mkdir($thumbsave,0777,true); }
        $itemimg = str_replace('../public','',$item['img']);
        if($itemimg && strpos($itemimg,'.')!==false){
            $texp = explode('.',$itemimg);
            $thubmimg = $thumbsave.md5($texp[0]).'.'.$texp[1];
            if(!file_exists($thubmimg)){
                $img = @file_get_contents($root.$itemimg);
                if($img===false){
                    $thubmimg = '';
                }else{
                    $img_path=$item['img'];
                    file_put_contents($thubmimg, $img);
                }
            }else{
                $img_path='已有：'.$thubmimg;
            }
        }else{
            $thubmimg = '';
        }
        

        $filesave = '../public/uploads/'.$item['indexs'].'/'.$item['id'].'/file/';
        if(!is_dir($filesave)){ mkdir($filesave,0777,true); }
        
        $imgs_path=[];
        if($item['file']){
            $fileimg = [];
            $files = json_decode($item['file'],true);
            if($files){
                foreach($files as $index => $file){
                    $itemimg = str_replace('../public','',$file);
                    if(strpos($itemimg,'.')!==false){
                        $fexp = explode('.', $itemimg);
                        $file_name = $filesave.md5($fexp[0]).'.'.$fexp[1];
                        
                        if(!file_exists($file_name)){
                            $img = @file_get_contents($root.$itemimg);
                            if($img===false){
                                
                            }else{
                                $imgs_path[] = $file;
                                file_put_contents($file_name, $img);
                                $fileimg[] = $file_name;
                            }
                        }else{
                            $fileimg[] = $file_name;
                        }
                    }
                 }
            }
            $fileimg = json_encode($fileimg);
            
        }else{
            $fileimg = '[]';
        }
        
        $thread = [
            'title'=>$item['title'],
            'age'=>$item['age'],
            'price'=>$item['price'],
            'project'=>$item['project'],
            'process'=>$item['process'],
            'qq'=>$item['qq'],
            'wechat'=>$item['wechat'],
            'phone'=>$item['phone'],
            'address'=>$item['address'],
            'dz'=>$item['dz'],
            'pid'=>$item['pid'],
            'cid'=>$item['cid'],
            'status'=>$item['status'],
            'browse'=>$item['browse'],
            'create_time'=>$item['create_time'],
            'author'=>$item['author'],
            'file'=>$fileimg,
            'img'=>$thubmimg,
            'face_value'=>$item['face_value'],
            'indexs'=>$item['indexs'],
            'only'=>$item['only'],
        ];
        $id = db::table('common_thread')->where('only', $item['only'])->value('id');
        if(!$id){
            Db::name('common_thread')->insert($thread);
            $result .= $key.'/'.$page.'----'.$item['id'].'----'.$item['title'].'----'.$img_path.'---'.json_encode($imgs_path).'<hr />'."\r\n";
            $total++;
        }else{
            Db::name('common_thread')->where('id', $id)->update(['file'=>$fileimg,'img'=>$thubmimg]);
            $result .= $key.'/'.$page.'----'.$item['id'].'----'.$item['title'].'---已存在(<a href="https://www.yd1.xyz/index/data/show.html?id='.$id.'">'.$id.'</a>)----'.$img_path.''.'<hr />'."\r\n";
            if($all>0){$total++;}
        }
    }
    if($total){
        $result .= '<script>window.setTimeout(function(){window.location.href="?all='.$all .'&page='.($page+1).'";},0);</script>';
    }else{
        $result = '<h1 id="seconds">3600</h1>'.$result.'<script>var seconds=document.getElementById("seconds").innerHTML*1;var second=0;window.setInterval(function(){second++;if(second>seconds){window.location.href="?all=0&page=1";}else{document.getElementById("seconds").innerHTML=(seconds-second)+"秒后刷新";}},1000);</script>';
    }
    return $result;
}
