/* 
 * seoplugins wordpress plugin.
 * custom javascript code for seoplugins plugin.
 * @author Andrei Dinca, Alexandra Ipate
 * @date 27.02.2011
 */
var seoplugins = {

    option: {
        uri: '',
        seoSettings: {},
        running: false,
        autoCheck : 0,
        countDown: 0,
        maxScore: 0,
        script: 'api.php'
    },

    init: function(options) {
        var self = this;
        
        //function that will initialize the script and do all the bindings
        self.option = jQuery.extend({}, self.option, options);   
        
        // if not exist
        if(!jQuery("#seoplugins_primary_keyword").size()){
            return false;
        }
        
        // init show rules
        self.showRules();
        
        self.seoCheckUpdate();
        
        jQuery("#seopluginsCheck").click(function(){
            jQuery("#seoTimeMarker").text(self.option.seoSettings.autoCheckTimes);
            self.seoCheckUpdate();
            return false;
        });
        
        // autocheck
        if(self.option.seoSettings.autoCheck == 'true'){
            jQuery("#seoTimeMarker").text(self.option.seoSettings.autoCheckTimes);
            self.option.countDown = setInterval(function(){self.pushCountDown()}, 1000);
        }
    },
    
    pushCountDown: function(){
        var self = this;
        
        var currCount = jQuery("#seoTimeMarker").text();
        if(currCount == 0){
            self.seoCheckUpdate();
            jQuery("#seoTimeMarker").text(self.option.seoSettings.autoCheckTimes);
        }else{
            jQuery("#seoTimeMarker").text(currCount - 1);
        }
    },
    
    showRules: function(){
        var self = this;

        jQuery.each(self.option.seoSettings.rulesCheck, function(key, val) {
            if(val == 'true'){
                self.option.maxScore++;
            }
        });
    },

    seoCheckUpdate: function(){
        var self = this;
        
        // collision prevent
        if(self.option.running == true) return false; // exit
        
        self.option.running = true;
        
        var pageContent = '';
        if(jQuery("#edButtonHTML").hasClass('active')){
            pageContent = jQuery("#content").val();
        }else{
            pageContent = jQuery("#content_ifr").contents().find('#tinymce').html()            
        }
        if(pageContent == '' || pageContent == null){
            pageContent = jQuery("#content").val();
        }

        jQuery('#seopluginsOverlay').css('display', 'block').css('height', jQuery('#seopluginsChecklist').height());
        
        jQuery.post(self.option.uri + self.option.script, 
        {
            primary_keyword : jQuery("#seoplugins_primary_keyword").val(),
            meta_title: jQuery("#seoplugins_title").val(),
            meta_description: jQuery("#seoplugins_description").val(),
            meta_keywords: jQuery("#seoplugins_keywords").val(),
            content: pageContent

        }, function(data) {
            // update status
            var points = 0;
            jQuery.each(data, function(key, val) {
                if(self.option.seoSettings.rulesCheck[key] == 'true'){
                    if(val > 0){
                        // particular case for density
                        if(key == 'keyword_meta_density'){
                            var keyword_density = self.option.seoSettings.rulesCheck['keyword_density'];
                            // update density
                            jQuery("#seoCurretDensity").text(val + "%");
                            if(val < keyword_density && val >= (keyword_density- 1)){
                                points++;
                                jQuery("#stats-" + key).attr('src', self.option.uri + 'smart_framework/images/ok.png');
                            }

                            if(val > keyword_density && val <= (keyword_density + 1)){
                                 points++;
                                 jQuery("#stats-" + key).attr('src', self.option.uri + 'smart_framework/images/ok.png');
                            }
                            
                        }else{
                            points++;
                            jQuery("#stats-" + key).attr('src', self.option.uri + 'smart_framework/images/ok.png');
                        }
                    }else{
                        jQuery("#stats-" + key).attr('src', self.option.uri + 'smart_framework/images/no.png');
                    }
                }
            });
            
            // Hide the label at start
            jQuery('#progress_bar .ui-progress .ui-label').hide();
            // Set initial value
            jQuery('#progress_bar .ui-progress').css('width', '7%');

            var progressCount = ((points / self.option.maxScore)  * 100).toFixed(1);
            // Simulate some progress
            jQuery('#progress_bar .ui-progress').animateProgress({
                progress : progressCount,
                duration : 1000,
                easing   : 'swing'
            }, function() {});
            
            jQuery('#seopluginsChecklist table').animate({opacity: 1}, 200);
            jQuery('#seopluginsOverlay').fadeOut(200);
            
            jQuery("#seoplugins_lastScore").val(progressCount);
            
            // unblock script
            self.option.running = false;
        }, 'json');
        
        /*
        jQuery.getJSON(self.option.uri + self.option.script,
        {
            primary_keyword : jQuery("#seoplugins_primary_keyword").val(),
            meta_title: jQuery("#seoplugins_title").val(),
            meta_description: jQuery("#seoplugins_description").val(),
            meta_keywords: jQuery("#seoplugins_keywords").val(),
            content: pageContent

        },
        function(data) { 
            
        });
        */
    }
};

(function( $ ){
    // Simple wrapper around jQuery animate to simplify animating options.progress from your app
    // Inputs: options.progress as a percent, Callback
    // TODO: Add options and jQuery UI support.
    $.fn.animateProgress = function(options, callback) { 
        
        return this.each(function() {
            
            var progress = options.progress;
            $(this).animate({
                width: options.progress + '%'
            }, {
                duration: options.duration, 
        
                // swing or linear
                easing: options.easing,

                // this gets called every step of the animation, and updates the label
                step: function( progress ){
                    var labelEl = $('.ui-label'),
                    valueEl = labelEl.find('.value');
          
                    if (Math.ceil(progress) < 20 && $('.ui-label', this).is(":visible")) {
                        labelEl.hide();
                    }else{
                        if (labelEl.is(":hidden")) {
                            labelEl.fadeIn();
                        };
                    }
                    valueEl.text((progress.toFixed(1)) + '%');
                    
                },
                complete: function(scope, i, elem) {
                    if (callback) {
                        callback.call(this, i, elem );
                    };
                }
            });
        });
    };
})( jQuery );