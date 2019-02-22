<?php 
/* *
 * 功能：Swoole服务器端操作类
 * 版本：1.0
 * 作者：江亮（Eden）
 * 修改日期：2019-02-20
 * 说明：
 * 创建http服务器、创建WebSocket服务器、操作进程（Process）、延时器、定时器、文件读取

 *************************类方法说明*************************
 * HttpServer:创建http服务器
 * WebsocketServer:创建WebSocket服务器
 * SwooleProcess:操作进程（Process）
 * SwooleSetTimeout：延时器
 * SwooleSetInterval：定时器
 * SwooleAsyncFile($filepath)：异步文件读取
 */
class Swoole{

		public function HttpServer(){
			#1.创建对象
			$httpServer=new swoole_http_server('0.0.0.0',8000);
			#2.监听端口请求：无-则不操作，有-则交给回调函数
			$httpServer->on('request',function($request,$response){
			         //var_dump($request);
			         //echo "<hr>";
			         //var_dump($response);
				 //响应内容
			         $response->end('hellp');

			 });
			#3.启动服务器
			$httpServer->start();
		}

		public function WebsocketServer(){
			###注意：fd指客户端唯一标识（每建立一个连接都有一个唯一标识，后期就通过该标识通信）

			#1.创建websocket服务
			$server = new swoole_websocket_server("0.0.0.0", 8003);
			#2.握手成功，触发回调函数
			$server->on('open', function (swoole_websocket_server $server, $request) {
			    echo "server: handshake success with fd{$request->fd}\n";
			});
			#3.收到消息，触发回调函数
			$server->on('message', function (swoole_websocket_server $server, $frame) {
			    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
			    $server->push($frame->fd, "this is server");
			});
			#3.关闭连接，触发回调函数
			$server->on('close', function ($ser, $fd) {
			    echo "client {$fd} closed\n";
			});
			#4.启动websocket服务
			$server->start();
		}


		//进程操作
		public function SwooleProcess(){
			swoole_set_process_name('php_master_process');

			//子进程创建好以后，是不会自己启动的，需要手动启动
			$worker = new swoole_process(function(){
			        swoole_set_process_name('php_son_process');
			        sleep(100);
			});

			$worker->start();
			//子进程启动以后，会沉睡1000秒，但是主进程在执行完一次以后就退出
			//了，那么子进程还有很长时间才会结束，这个时候会造成子进程无法管理
			swoole_process::wait();
		}

		//延时器
		public function SwooleSetTimeout($time,$fun){
			swoole_timer_after($time,function(){
				$fun;
			});
		}

		//定时器
		public function SwooleSetInterval($time,$fun){
			swoole_timer_tick($time,function(){
			       $fun;
			});
		}

		//异步文件操作
		public function SwooleAsyncFile($filepath){
			swoole_async_readfile($filepath,function($filename,$contents){
			        echo $contents;
			});
		}


}

 $swoole = new Swoole();

