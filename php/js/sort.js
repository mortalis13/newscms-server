
var headers,sort,source
var archiveHeaders=["date","title","user"]
var adminHeaders=["date","title"]

$(function(){
	var addr=location.href
	var userAddr=addr.indexOf("index.php")
	var adminAddr=addr.indexOf("admin.php")
	var cookies=getCookies()
	
	var table=$("#tNewsArchiveUser")
	headers=archiveHeaders
	sort=cookies.sortArchive
	source="sortArchive"
	if(adminAddr!=-1){
		table=$("#tNews")
		headers=adminHeaders
		sort=cookies.sortAdmin
		source="sortAdmin"
	}
	
	makeSortable(table)
	setInitSort(table)
})

function setInitSort(table){
	var sortHeader=headers[0]
	var direction="DESC"
	
	if(sort){
		var data=sort.split(" ")
		var sortHeader=data[0]
		var direction=data[1]
	}
	var n=headers.indexOf(sortHeader)
	sortrows(table,n,direction)
}

function sortOnClick(table,n) {
	var sortHeader=headers[n]
	var direction="ASC"
	
	if(sort){
		var data=sort.split(" ")
		var cSortField=data[0]
		var cDirection=data[1]
		if(cSortField==sortHeader){
			if(cDirection == "ASC")
			  direction="DESC";
			else if(cDirection == "DESC")
			  direction="ASC";
		}
	}
	sort=sortHeader+" "+direction;
	setCookie(source,sort);
	sortrows(table,n,direction)
}

function sortrows(table,n,direction) {
	var tbody = $("tbody",table)
	var rows = $("tr",tbody)
	rows=$.makeArray(rows)
	
	rows.sort(function(row1,row2){
		var cell1=$($("td",row1)[n])
		var cell2=$($("td",row2)[n])
		var val1=cell1.text()
		var val2=cell2.text()
		if(direction=="ASC") return asc(val1,val2)
		else return desc(val1,val2)
	})
	rows.map(function(row){tbody.append(row)})
	
	var thead=$("thead th span",table)
	thead.removeClass()
	thead.css("position","relative")
	
	var span=$(thead[n])
	if(direction=="ASC")
		span.addClass("sortUp")
	else
		span.addClass("sortDown")
}

function makeSortable(table) {
	var headers=$("th",table)
	headers.map(function(n,th){
		$(th).click(function(){
			sortOnClick(table,n)
		})
	})
}

function asc(val1,val2){
	if (val1 < val2) return -1
	else if (val1 > val2) return 1
	else return 0
}

function desc(val1,val2){
	if (val1 > val2) return -1
	else if (val1 < val2) return 1
	else return 0
}

function getCookies() {
	var cookies = {};          
	var all = document.cookie; 
	if (all === "")            
		return cookies;        
	var list = all.split("; "); 
	for(var i = 0; i < list.length; i++) { 
		var cookie = list[i];
		var p = cookie.indexOf("=");      
		var name = cookie.substring(0,p); 
		var value = cookie.substring(p+1); 
		value = decodeURIComponent(value); 
		cookies[name] = value;              
	}
	return cookies;
}

function setCookie(name,value,life,path){
	var cookie=name+"="+encodeURIComponent(value)
	document.cookie=cookie
}
