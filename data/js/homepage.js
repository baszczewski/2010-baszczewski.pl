//------------------------------------------------------------------------------------------------------------------
var app;
//------------------------------------------------------------------------------------------------------------------
var ajax = new Class(
{
	Implements: [Events, Options],
    options: 
    { 
    	timeout:10000,
    	url:'ajax',
    	method:'post',
    	params:null,
    	action:'index'
    },
    error:function()
    {
    	parent.fireEvent('complete', {'success':false});
    },
    initialize: function(options)
    {	
    	this.setOptions(options);
    	var parent=this;
    	
    	var futdate = new Date()
		var expdate = futdate.getTime()
    	
    	var myTimer = parent.error.delay(parent.options.timeout); 
    	var myRequest = new Request(
    	{
    		method: this.options.method, 
    		url: this.options.url+'/'+this.options.action+'/'+expdate,
    		onSuccess:function(result)
    		{
    			r = JSON.decode(result);
    			if (r.success==true)
    			parent.fireEvent('complete', r);
    			else
    			parent.error();
    			myTimer = $clear(myTimer);
    		},
    		onFailure:function()
    		{
    			parent.error();
    		}
    	}).send('data='+JSON.encode(parent.options.params));
    }
});

//------------------------------------------------------------------------------------------------------------------
var ratingItem = new Class(
{
	Implements: [Events, Options],
    options: 
    { 
    	enabled : true,
    	images	: ['data/images/ajax.gif']
    },
    setProgress:function()
    {
    	var parent=this;
   		parent.loading.set('html','<img alt="" src="'+parent.options.images[0]+'"/>');
	    parent.element.set('styles',{display:'block'}).setOpacity(1).set('morph',{'onComplete':function()
	    {
	    	parent.element.set('styles',{display:'none'});
	    	parent.loading.set('styles',{display:'block'});
	    }}).morph({opacity:0});
    },
    setComplete:function(text)
    {
    	var parent=this;
    	setTimeout(function()
		{
	   	    parent.loading.set('html',text);
	    	setTimeout(function()
	    	{	
	    		parent.loading.set('styles',{display:'none'});
	    		parent.element.set('styles',{display:'block'}).setOpacity(0).set('morph',{'onComplete':function()
	    		{
	    		}}).morph({opacity:1});
			},1000);
		},500);
    },
    getRating:function()
    {
    	var parent 	= this;
       	var temp	= 0;
  		for (i=0;i<parent.stars.length;i++)
  		{ 
  			if (parent.stars[i].getProperty('class')=='star1') temp++;
  		}
   		return temp;
    },
    setRating:function(i)
    {
    	var parent 	= this;
   		i = Math.ceil(i)-1;
		for (j=0;j<parent.stars.length;j++)
		if (i>=j)
		parent.stars[j].set('class','star1');
		else
		parent.stars[j].set('class','star2');
    },
    done:function(a,b)
    {
      	//hack for tip :( (remove old stars, remove old tip and insert new two divs with new tip)
		/*
		var parent 	= this;
		parent.element.set('html','');
		parent.parent.tips.hide();
		parent.parent.tips.detach(parent.element);
		parent.element.removeProperty('title');
   		var element1 = new Element('div',{'class':'tips rating','title':'Średnia','rel':(a+' z '+b+' ocen'),'styles':{'background':'url(data/images/star1.png) repeat-x','float':'left','width':19*(Math.ceil(parent.rating))}}).inject(parent.element);
   		parent.parent.tips.attach(element1);
   		var element2 = new Element('div',{'class':'tips rating','title':'Średnia','rel':(a+' z '+b+' ocen'),'styles':{'background':'url(data/images/star2.png) repeat-x','float':'left','width':19*(6-Math.ceil(parent.rating))}}).inject(parent.element);
   		parent.parent.tips.attach(element2);
   		*/
    },
    addAction:function(action,item,index)
    {
    	var parent = this;
		switch(action)
		{
		case 'preview':
			item.addEvents(
			{
	  			'mouseenter':function()
	  			{
					parent.setRating(index+1);
					item.setOpacity(0.4);
	  			},
	  			'mouseleave':function()
	  			{
	  				parent.setRating(index+1);
					item.setOpacity(1);
	  			}
	  		});
			parent.element.addEvent('mouseleave',function()
			{
				parent.setRating(parent.rating);
				item.setOpacity(1);
			});
			break;
		case 'vote':
			item.addEvent('click',function()
			{
				if (parent.ajax==false)
				{
					parent.setProgress();
					request = new ajax(
					{
						params:{'rating':index+1,'id':parent.id},
						action:'rating',
						'onComplete':function(data)
						{
							parent.ajax = true;
							if (data.success==true)
							{
								if (data.rating!=null)
								{
									parent.setRating(data.rating);
									parent.rating = data.rating;
									parent.done(data.rating,data.count);
									parent.setComplete('oddano głos');
								}
								else
								parent.setComplete('już głosowano');
							}
						}
					});
		    	}
		    	else
		    	{
		    		parent.setProgress();
		    		setTimeout(function()
		    		{
		    			parent.setComplete('już głosowano');
		    		},500);
		    	}
	    	});
			break;
		default:
		}
    },
    initialize: function(parent,item,options)
    {
    	this.setOptions(options);
    	this.parent = parent;
    	var parent  = this;
    	{
    		new Asset.images(parent.options.images);
    	
	   		parent.element			= item.getFirst();
	   		parent.stars		   	= [];
	   		var temp				= parent.element.getProperty('id');
	   		temp 					= temp.substr(temp.indexOf("_")+1,temp.length);
	   		parent.id 		 		= temp;
	   		parent.ajax 			= false;
	   		
	   		parent.element.getElements('div').each(function(star)
	   		{
	   			parent.stars.include(star);
	   		});
	   		parent.rating   = parent.getRating();
	   		parent.loading	= new Element('div',{'class':'loading'}).inject(parent.element,'after');
		    
			for (i=0;i<parent.stars.length;i++)
	   		{
	   			parent.addAction('vote',parent.stars[i],i);
	   			parent.addAction('preview',parent.stars[i],i);
	   		}
	   		
    	}
    }
});
var rating = new Class(
{
	Implements: [Events, Options],
    initialize: function(parent,options)
    {
		$$('.rating').each(function(item)
	    {
	    	new ratingItem(parent,item);
	    });
    }
});
//------------------------------------------------------------------------------------------------------------------
var comments = new Class(
{
	Implements: [Events, Options],
    initialize: function(parent,options)
    {
		if ($('newcomment'))
		{
			$('newcomment').addEvent('click',function(event)
			{
				event.stop();

				$('comment').getFirst().set('styles',{display:'block'});
				$('newcomment').dispose();
				var go_to = new Fx.Scroll(window,
			    {
					duration: 600,
			    	wait: true,
			    	onComplete:function()
			    	{
			    	}
			    }).toElement($('frame_bottom'));
			});
		}
    }
});
//------------------------------------------------------------------------------------------------------------------
var logo = new Class(
{
    Implements: [Events, Options],
    animation:function()
    {
	var parent = this;

	var bp_left =  parent.i*(51)+1;
	$('logo').set('styles',{'background-position':'-'+(bp_left)+'px -111px'});
	
	parent.sleep = 0;
	if (this.i==0)
	    parent.sleep = 3000;
	else
	    parent.sleep = 80;

	setTimeout(function(){parent.animation()},parent.sleep);
	
	if ( (parent.r % 2)==0)
	    parent.i++;
	else
	{
	    parent.i--;
	}
	if (parent.i>5)
	{
	    //this.i = 0;
	    parent.r++;
	}
	if (parent.i<0)
	{
	    parent.i = 0;
	    parent.r--;
	}
    },
    initialize: function(parent,options)
    {
	this.i = 0;
	this.r = 1;
	this.animation();
    }
});
//------------------------------------------------------------------------------------------------------------------
var homepage = new Class(
{
	Implements: [Events, Options],
    initialize: function(options)
    {
    	this.setOptions(options);
    	this.rating = new rating(this);
	this.logo = new logo(this);
    	this.comments = new comments(this);

	name = "imie";
	secondname = "nazwisko";
	if ($('mail'))
	{
	    temp = name+'@'+secondname+'.pl';
	    $('mail').set('html','<a href="mailto:'+temp+'">'+temp+'</a>');
	}
	if ($('skype'))
	    $('skype').set('html','skype');
	if ($('phone'))
	    $('phone').set('html','+48 123 123 123');
    }
});
//------------------------------------------------------------------------------------------------------------------