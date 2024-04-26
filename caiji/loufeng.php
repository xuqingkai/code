function caiji(){
    $result='';
    $root = 'https://www.example.com';
    $page = intval('0'.$_GET['page']);
    if($page<1){$page=1;}
    $str = file_get_contents($root.'/news/list/json?page='.$page);
    $json = json_decode($str,true);
    $total=0;
    foreach($json as $index=>$item){
        $total++;
        $img_dir = '../public/uploads/'.date('ymd',time()).'/'.$item['id'].'/thumb';
        if(!is_dir($img_dir)){ mkdir($img_dir,0777,true); }

        if($item['img'] && strpos($item['img'],'.') !== false){
            $img_name = substr(0, strrpos($item['img'], '.'));
            $img_ext = substr(strrpos($item['img'], '.'));
            $img_path = $img_dir.'/'.md5($img_name).$img_ext;
            if(!file_exists($img_path)){
                $img_file = @file_get_contents($root.$item['img']);
                if($img_file===false){
                    $img_path = '';
                }else{
                    file_put_contents($img_path, $img_file);
                }
            }
        }else{
            $img_path = '';
        }

        $imgs_dir = '../public/uploads/'.date('ymd',time()).'/'.$item['id'].'/file';
        if(!is_dir($imgs_dir)){ mkdir($imgs_dir,0777,true); }
        
        if($item['file']){
            $imgs_path = [];
            $imgs_json = json_decode($item['file'],true);
            if($imgs_json){
                foreach($imgs_json as $index_imgs => $item_file){
                    if(strpos($item_file,'.') !== false){
                        $img_name = substr(0, strrpos($item_file, '.'));
                        $img_ext = substr(strrpos($item_file, '.'));
                        $item_path = $imgs_dir.'/'.md5($img_name).$img_ext;
                        if(!file_exists($item_path)){
                            $img_file = @file_get_contents($root.$item_file);
                            if($img_file!==false){
                                file_put_contents($item_path, $img_file);
                                $imgs_path[] = $item_path;
                            }
                        }else{
                            $imgs_path[] = $item_path;
                        }
                    }
                 }
            }
            $imgs_path = json_encode($imgs_path);
        }else{
            $imgs_path = '[]';
        }

        $thread = [
            'title'=>$item['title'],
            'author'=>$item['author'],
            'img'=>$img_path,
            'file'=>$imgs_path,
            'create_time'=>$item['create_time'],
        ];
        $news = db::table('news')->where('origin_id', $item['id'])->find();
        if(!$news){
            Db::name('common_thread')->insert($thread);
        }
        $result .= $index.'/'.$page.'----'.$item['id'].'----'.$item['title'].'----'.$root.$item['img'].'<hr />';
    }

    if($total){
        $result .= '<script>window.location.href="?page='.($page+1).'"</script>';
    }
    return $result;
}
