function GetE(id) {return document.getElementById(id);}
function f_chkmsgform(frm)
{
	if (frm.x_Name!=null && frm.x_Name.value == "")
	{
		alert("姓名不能为空");
		frm.x_Name.focus();
		return false;
	}
	if (frm.x_Name.value.length <= 1)
	{
		alert("请正确填写姓名");
		frm.x_Name.focus();
		return false;
	}
	if (frm.x_Phone!=null && frm.x_Phone.value == "")
	{
		alert("联系电话不能为空");
		frm.x_Phone.focus();
		return false;
	}
	if (frm.x_Content!=null && frm.x_Content.value == "")
	{
		alert("留言内容不能为空");
		frm.x_Content.focus();
		return false;
	}
	return true;
}


//记录每个投票星星的状态
var star_group_status = new Array();
function star_clk(obj)
{
	var obj_star_group = obj.parentNode;
	var obj_labels =  obj_star_group.getElementsByTagName("label");
	//obj_labels[0].innerHTML = obj.title;

	//修改选中值
	var obj_values =  obj_star_group.getElementsByTagName("input");
	obj_values[0].value = obj.getAttribute("value");

	//选中的星星
	star_group_status[obj_star_group.star_group]["select_obj"] = obj;
}
function star_hover(obj)
{
	//展示标签文字
	var obj_star_group = obj.parentNode;
	var obj_labels =  obj_star_group.getElementsByTagName("label");
	//obj_labels[0].innerHTML = obj.title;

	//修改星星的展示式样
	var obj_as =  obj_star_group.getElementsByTagName("a");
	for(var i=0; i < obj_as.length; i++)
	{
		var obj_a = obj_as[i];
		var s = obj_a.className;

		if (s.match(" select"))	s = s.replace(/ select/, "");
		obj_a.className = s;
	}
	obj.className += " select";

	//鼠标移动的星星
	if(star_group_status[obj_star_group.star_group] == null)star_group_status[obj_star_group.star_group] = new Array();
	star_group_status[obj_star_group.star_group]["hover_obj"] = obj;
}
function star_mouseout(obj_star_group)
{
	var obj_labels =  obj_star_group.getElementsByTagName("label");
	obj_labels[0].innerHTML = "";
	//修改星星的展示式样
	var obj_as =  obj_star_group.getElementsByTagName("a");
	for(var i=0; i < obj_as.length; i++)
	{
		var obj_a = obj_as[i];
		var s = obj_a.className;

		if (s.match(" select"))	s = s.replace(/ select/, "");
		obj_a.className = s;
	}
	if(null != star_group_status[obj_star_group.star_group]["select_obj"])
	{
		star_group_status[obj_star_group.star_group]["select_obj"].className += " select";
		//obj_labels[0].innerHTML = star_group_status[obj_star_group.star_group]["select_obj"].title;
	}
}
//提交评论
function star_comments_submit(form)
{
	var objs =  document.getElementsByName("star_value[]");
	for(var i=0; i < objs.length; i++)
	{
		var obj = objs[i];
		if (obj.value == "")
		{
			alert("请您选择星星评分，然后再提交评论");
			return false;
		}
	}

	if(form.x_Content.value == form.x_Content.title)
	{
		alert("请填写培训感受.");
		form.x_Content.focus();
		return false;
	}

	if(form.x_Phone != null)
	{
		if(form.x_Phone.value == form.x_Phone.title)
		{
			alert("请填写联系电话.");
			form.x_Phone.focus();
			return false;
		}
	}

	if(form.x_OrderId != null)
	{
		if(form.x_OrderId.value == form.x_OrderId.title)
		{
			alert("请填写报名码.");
			form.x_OrderId.focus();
			return false;
		}
	}
	return true;
}