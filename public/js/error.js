var ERROR_OUTPUT = function(error)
{
	//这里加入提示框
	//sweetAlert(error.error, "error");
	

	if(error.script != null)
	{
		//处理错误重定向脚本
		eval(error.script);
	}
	
	return error.error;
}