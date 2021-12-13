$(document).ready(function() {
  var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
      var matches, substringRegex;
      matches = [];
      substrRegex = new RegExp(q, 'i');
      $.each(strs, function(i, str) {
        if (substrRegex.test(str)) {
          matches.push(str);
        }
      });
      cb(matches);
    };
  };
    $('.typeahead').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  },
  {
    name: 'states',
    source: substringMatcher(states)
  });
  
  var remote_users = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('user'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote:{
      	url:rooturl + "/index.php/Search" + url + "searchusers" + shtml + "?format=json&q=%QUERY",
      	wildcard: '%QUERY'
      }
  });
  remote_users.initialize();
  $('.typeaheadgroup').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  },
  {
    name: 'users',
    displayKey: 'user',
    source: remote_users.ttAdapter()
  });
})
document.getElementById("web_editor_con2").className+=" text-input textarea";
jQuery(".tm-input").tagsManager({maxTags:'5',validator:function(tag){
	var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");
	if(pattern.test(tag) || (tag.length>10)){
		return false;	
	}else{
		return true;	
	}
}});
jQuery(".tm-inputgroup").tagsManager({maxTags:'10',validator:function(tag){
	var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");
	if(pattern.test(tag) || (tag.length>10)){
		return false;	
	}else{
		return true;	
	}
}});