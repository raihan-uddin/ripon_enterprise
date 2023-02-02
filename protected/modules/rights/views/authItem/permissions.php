<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Permissions'),
); ?>

<div id="permissions">

	<h2><?php echo Rights::t('core', 'Permissions'); ?></h2>

	<p>
		<?php echo Rights::t('core', 'Here you can view and manage the permissions assigned to each role.'); ?><br />
		<?php echo Rights::t('core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.', array(
			'{roleLink}'=>CHtml::link(Rights::t('core', 'Roles'), array('authItem/roles')),
			'{taskLink}'=>CHtml::link(Rights::t('core', 'Tasks'), array('authItem/tasks')),
			'{operationLink}'=>CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
		)); ?>
	</p>

	<p><?php echo CHtml::link(Rights::t('core', 'Generate items for controller actions'), array('authItem/generate'), array(
	   	'class'=>'generator-link btn btn-secondary',
	   	'style'=>'color: white;',
	)); ?></p>

    <style>
        thead th { position: sticky; top: 0; z-index: 2}
        tbody td { position: sticky; left: 0; z-index: 1}
    </style>
    <div>
        <input type='text' id='search' placeholder='Search Text' class="text-field form-control" style="width: 100%;">
    </div>
    <div>
        <?php
        $query_to_get_models = "SELECT name,description FROM AuthItem WHERE type = 2";
        $data = Yii::app()->db->createCommand($query_to_get_models)->queryAll();
        ?>
        <select id="userRoleId" class="form-control" style="margin-top: 10px;">
            <option>Select One</option>
            <?php foreach($data as $d){ ?>
                <option value="<?php echo $d['name']; ?>"><?php echo $d['description']; ?></option>
            <?php }?>
        </select>
        <br>
        <input type='button' id='assignRevokeBtn' style="margin-top: 10px;" value="Assign / Revoke" class="btn btn-success">
        <input type="hidden" name="assignRevokeUrls" id="assignRevokeUrls">
        <div id="successErrorDiv"></div>

    </div>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>'{items}',
		'emptyText'=>Rights::t('core', 'No authorization items found.'),
		'htmlOptions'=>array('class'=>'grid-view permission-table'),
		'columns'=>$columns,
	)); ?>

	<p class="info">*) <?php echo Rights::t('core', 'Hover to see from where the permission is inherited.'); ?></p>

	<script type="text/javascript">

		/**
		* Attach the tooltip to the inherited items.
		*/
		jQuery('.inherited-item').rightsTooltip({
			title:'<?php echo Rights::t('core', 'Source'); ?>: '
		});

		/**
		* Hover functionality for rights' tables.
		*/
		$('#rights tbody tr').hover(function() {
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});

        $(document).ready(function(){
            $('#search').keyup(function(){
                // Search text
                var text = $(this).val();

                text = text.replace(/\//g, '.');
                // Hide all content class element
                $('.items tbody tr').hide();

                // Search
                $('.items tbody tr:contains("'+text+'")').closest('tr').show();
            });
        });

        jQuery.expr[":"].contains = function(obj,index,meta) {
          /*  console.log(obj);
            console.log(index);
            console.log(meta);*/
            return jQuery(obj).text().toUpperCase().indexOf(meta[3].toUpperCase()) >= 0;
        };




        var iterate = 0;
        $('.items').find('tr').each(function(){
            iterate = iterate+1;
            $(this).find('.permission-column').before('<td><input type="checkbox" value="'+iterate+'" id="chk_'+iterate+'" name="chk_'+iterate+'" class="chk"></td>');
        });
        $('#yw0_c0').before('<th><input name="chkAll" id="chkAll" class="chkAll" type="checkbox"></th>');


        $(document).ready(function(){
            document.getElementById("chkAll").checked = false;
        });

        $(".chk").on("click", function(){
            if(this.checked){
                var e = document.getElementById("userRoleId");
                var selectedRoleValue = e.options[e.selectedIndex].value;
                var selectedRoleText = e.options[e.selectedIndex].text;
                var role = encodeURIComponent(selectedRoleValue.replace(/ /gi,"+"));
                var urls = $("#assignRevokeUrls").val();
                var crt = 0;
                var childRef = $(this).closest('tr').find('.permission-column a').attr('href');
                var theurl = window.location.origin;
                theurl += childRef;
                var child = getQuery(theurl, 'name');
                $(this).closest('tr').find('.role-column').each(function(){
                    crt = crt + 1;
                    var actualUrl = "";
                    var textAssignRevoke = $(this).find('a').text();
                    var action = '';
                    if(textAssignRevoke == 'Assign'){
                        action = 'assign';
                    }else{
                        action = 'revoke';
                    }
                    var roleHeader = $("#yw0_c"+crt).text();
                    if(roleHeader == selectedRoleText){
                        actualUrl = "/"+action+"?name="+role+"&child="+child;
                        var urlsArr = urls.split('@');
                        if(urlsArr.indexOf(actualUrl) >= 0){

                        }else{
                            urls += actualUrl+"@";
                        }
                    }
                });
                $("#assignRevokeUrls").val(urls);
            }else{
                var e = document.getElementById("userRoleId");
                var selectedRoleValue = e.options[e.selectedIndex].value;
                var selectedRoleText = e.options[e.selectedIndex].text;
                var role = encodeURIComponent(selectedRoleValue.replace(/ /gi,"+"));
                var urls = $("#assignRevokeUrls").val();
                var crt = 0;
                var childRef = $(this).closest('tr').find('.permission-column a').attr('href');
                var theurl = window.location.origin;
                theurl += childRef;
                var child = getQuery(theurl, 'name');
                $(this).closest('tr').find('.role-column').each(function(){
                    crt = crt + 1;
                    var actualUrl = "";
                    var textAssignRevoke = $(this).find('a').text();
                    var action = '';
                    if(textAssignRevoke == 'Assign'){
                        action = 'assign';
                    }else{
                        action = 'revoke';
                    }
                    var roleHeader = $("#yw0_c"+crt).text();
                    if(roleHeader == selectedRoleText) {
                        var role = $("#yw0_c"+crt).text();
                        actualUrl = "/"+action+"?name="+role+"&child="+child;
                        var urlsArr = urls.split('@');
                        if(urlsArr.indexOf(actualUrl) > -1){
                            urlsArr.splice(actualUrl, 1);
                        }
                        urls = urlsArr.join('@');
                    }
                });
                $("#assignRevokeUrls").val(urls);
            }

        });

        $("#assignRevokeBtn").on("click", function(){
            var e = document.getElementById('userRoleId');
            var roleName = e.options[e.selectedIndex].value;
            if(roleName == 'Select One'){
                alert("Please Select a Role First!");
                return false;
            }
            var e = document.getElementById("userRoleId");
            var selectedRoleValue = e.options[e.selectedIndex].value;
            var roleName = encodeURIComponent(selectedRoleValue.replace(/ /gi,"+"));
            roleName = 'name='+roleName;
            var requestUrls = $("#assignRevokeUrls").val();
            var splittedUrls = requestUrls.split('@');
            if(requestUrls != ""){
                for(var i = 0; i<splittedUrls.length; i++){
                    if(splittedUrls[i] != '' && splittedUrls[i].includes(roleName)){
                        console.log(splittedUrls[i]);
                        $.ajax({
                            type:'POST',
                            url: '<?php echo Yii::app()->createAbsoluteUrl("rights/authItem/") ?>'+splittedUrls[i],
                            data:{ ajax:1 },
                            success:function() {
                                $('#permissions').load('/sm_erp/sm_erp/rights/authItem/permissions', { ajax:1  });
                            }
                        });
                    }
                }
            }else{
                alert("Please Check at least One Item!");
            }
        });

        $("#chkAll").on("click", function(){
            if(this.checked){
                $('.chk:visible').each(function(){
                    this.checked = true;

                    var e = document.getElementById("userRoleId");
                    var selectedRoleValue = e.options[e.selectedIndex].value;
                    var selectedRoleText = e.options[e.selectedIndex].text;
                    var role = encodeURIComponent(selectedRoleValue.replace(/ /gi,"+"));
                    var urls = $("#assignRevokeUrls").val();
                    var crt = 0;
                    var childRef = $(this).closest('tr').find('.permission-column a').attr('href');
                    var theurl = window.location.origin;
                    theurl += childRef;
                    var child = getQuery(theurl, 'name');

                    $(this).closest('tr').find('.role-column').each(function(){
                        crt = crt + 1;
                        var actualUrl = "";
                        var textAssignRevoke = $(this).find('a').text();
                        var action = '';
                        if(textAssignRevoke == 'Assign'){
                            action = 'assign';
                        }else{
                            action = 'revoke';
                        }
                        var roleHeader = $("#yw0_c"+crt).text();
                        if(roleHeader == selectedRoleText){
                            actualUrl = "/"+action+"?name="+role+"&child="+child;
                            var urlsArr = urls.split('@');
                            if(urlsArr.indexOf(actualUrl) >= 0){

                            }else{
                                urls += actualUrl+"@";
                            }
                        }
                    });
                    $("#assignRevokeUrls").val(urls);
                });
            }else{
                $('.chk:visible').each(function(){
                    this.checked = false;
                    $("#assignRevokeUrls").val('');
                });
            }
        });

        $("#userRoleId").on("change", function(){
            $('.chk').each(function(){
                this.checked = false;
                $("#assignRevokeUrls").val('');
            });
            document.getElementById('chkAll').checked = false;
        });


        // function to get a specific param from url
        function getQuery(url, param) {
           return (url.match(new RegExp('[?&]' + param + '=([^&]+)')) || [, null])[1];
        }

    </script>

</div>
