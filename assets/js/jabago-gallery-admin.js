var selected_images = 0

function select_images(label = []){
    upload = wp.media({title: 'Add image to gallery', button: {text: 'Use this image'}, multiple: 'add'}).on('select', function(){
        var attachment = upload.state().get('selection')
        let _get_image = []
        attachment.map(function(getImage){

            getImage = getImage.toJSON()
            selected_images += 1
            image_html(selected_images, getImage.url, label)
        })
        

    }).open()
}


function image_html(id, url, label = []){


    var html = `<img src="` + url + `" alt="" width="100px" height="100px" id="image-` + id + `">
    <input type="hidden" id="image-url-` + id + `" value="` + url + `" name="url[]">
    <div class="image-info">
        <label for="title">` + label[0] + `</label>
        <input type="text" name="title[]" id="title">
        <label for="alt-text">` + label[1] + `</label>
        <input type="text" name="alt-text[]" id="alt-text">
        <label for="redirect_url">` + label[2] + `</label>
        <input type="text" name="redirect_url[]" id="redirect_url">
        <label for="description">` + label[3] + `</label>
        <textarea name="description[]" id="description" cols="10" rows="2"></textarea>
    </div>
    <div class="image-actions">
        <a onclick="remove_image('image-` + selected_images + `')" class="button">` + label[4] + `</a>
    </div>`;

    var target = document.getElementById('images')
    var new_image = document.createElement('div')
    new_image.classList = 'image'
    new_image.id = 'image-'+selected_images

    new_image.innerHTML = html

    target.appendChild(new_image)
    
}

function httpGet(theUrl)
{
    if(confirm('Are you sure you want to delete this item?')){
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
        xmlHttp.send( null );
        return xmlHttp.responseText;
    }
}

function remove_image(id){
    document.getElementById(id).remove()
}
