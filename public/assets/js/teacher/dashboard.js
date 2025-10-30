$(document).ready(function(){
    
   
    fetchBadgeCategories();
    
    
    
});

    function renderstats(data){
        
        $('#pending').text(data['pending']);
        $('#approved').text(data['approved']);
        $('#badges').text(data['reverted']);
        
        
        
    }


    function fetchBadgeCategories() {
        $.ajax({
            url: '/api/',
            method: 'POST',
            dataType: 'json',
            data: { method: 'getTeacherStats' },
            success: function(response) {
                if (response.status) {
console.log(response);
renderstats(response.data);
                } else {
                    console.error('Failed to fetch categories:', response.message);
                }
            },
            error: (xhr, status, error) => console.error('AJAX Error:', error)
        });
    } 
    
