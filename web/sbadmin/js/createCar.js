$(document).ready(function() {

//    var endpoint = window.location + '../../../src/VehicleBundle/Controller/MainController.php';
    
    
    var selectModel = $(document).find('form.form-horizontal').find('select#vehiclebundle_car_Model');
    var optionModel = selectModel.find('option');
    optionModel.remove();
    
    function loadForm() {
        
        var brand = $(document).find('form.form-horizontal').find('select#vehiclebundle_car_Brand').eq(0).val();
        
        $.post('http://127.0.0.1:8000/jsonmodels', {
            brandId: brand
        })
        .done(function(json) {
            console.log(json);
            var models = JSON.parse(json);
            console.log(models);
            
            var selectModel = $(document).find('form.form-horizontal').find('select#vehiclebundle_car_Model');
            var optionModel = selectModel.find('option');
            optionModel.remove();
            for ( var i = 0; i < models.length; i++) {
                var model = $("<option value ='" + models[i].id + "'>" + models[i].name + "</option>");
                selectModel.append(model);
            }
            
        })
	.fail(function(xhr) {
            console.log('load error', xhr);
	})
	.always(function(xhr) {
            console.log("ajax is working");
        });
        
    }
    
    loadForm();

    
    function updateForm(brand) {
        
        $.post('http://127.0.0.1:8000/jsonmodels', {
            brandId: brand
        })
        .done(function(json) {
            console.log(json);
            var models = JSON.parse(json);
            console.log(models);
            
            var selectModel = $(document).find('form.form-horizontal').find('select#vehiclebundle_car_Model');
            var optionModel = selectModel.find('option');
            optionModel.remove();
            for ( var i = 0; i < models.length; i++) {
                var model = $("<option value ='" + models[i].id + "'>" + models[i].name + "</option>");
                selectModel.append(model);
            }
            
        })
	.fail(function(xhr) {
            console.log('load error', xhr);
	})
	.always(function(xhr) {
            console.log("ajax is working");
        });
        
    };

    var selectBrand = $(document).find('form.form-horizontal').find('select#vehiclebundle_car_Brand');
    selectBrand.on('change', function() {
        var brand = $(this).val();
        console.log(brand);
        updateForm(brand);
        
    });
           

});


