var pet = function(name){
	var getName = function(){
		return name;
	}
	return getName;
},
mypet = pet("vivie");


var createPet = function(name){
	var sex;

	return {
		setName: function(newName){
			name = newName;
		},
		getName: function(){
			return name;
		},
		getSex: function(){
			return sex;
		},
		setSex: function(newSex){
			if(typeof newSex == "string" && (newSex.toLowerCase() == 'male' || newSex.toLowerCase() == 'female')){
				sex = newSex;
			}
		}
	}
}

var pet = createPet("vivie");
pet.getName();

pet.setName("oliver");
pet.setSex("male");
pet.getSex();
pet.getName();