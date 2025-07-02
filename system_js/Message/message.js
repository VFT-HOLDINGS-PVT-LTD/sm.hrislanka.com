$(function(){

    $('#tree-default').jstree({
        //"core" : {
        //    "themes" : {
        //        "responsive": false
        //    }            
        //},
        "types" : {
            "default" : {
                "icon" : "fa fa-folder icon-state-warning icon-lg"
            },
            "file" : {
                "icon" : "fa fa-file icon-state-warning icon-lg"
            }
        },
        "plugins": ["types"]
    });



    $('#tree-checkable').jstree({
        'plugins': ["wholerow", "checkbox", "types"],
        'core': {
            "themes" : {
                "responsive": false
            },    
            'data': [{ 
                    "text": "Select All Branches",
                    "children": [
                      
                      
                     {
                         
                        "value" : "",
                        "text": "branch",
                        "icon": "fa fa-user icon-state-danger"
                           
                    },
                     {
                      
                        "value" : "",
                        "text": "branch1",
                        "icon": "fa fa-user icon-state-danger"
                         
                    }
                    
                
                    
                    
                    ]
                }
                
            ]
        },
        "types" : {
            "default" : {
                "icon" : "fa fa-folder icon-state-warning icon-lg"
            },
            "file" : {
                "icon" : "fa fa-file icon-state-warning icon-lg"
            }
        }
    });



});