            jQuery(document).ready(function ($) {
                $('#tabs').tab();
            });

            jQuery.createXMLDocument = function(string) {
                var browserName = navigator.appName;
                var doc;
                if (browserName == 'Microsoft Internet Explorer') {
                    doc = new ActiveXObject('Microsoft.XMLDOM');
                    doc.async = 'false'
                    doc.loadXML(string);
                }
                else {
                    doc = (new DOMParser()).parseFromString(string, 'text/xml');
                }
                return doc;
            }

            function addData(data) {
                    var items = $(data).find("item");
                    var doc = $.createXMLDocument(items.text());
                    for(i=0; i<doc.childNodes[0].children.length; i++) {
                        var items = doc.childNodes[0].children[i];
                        $("#"+items.nodeName).find(".api-data").empty();
                        $.each(items.children, function(index, el) {
                            if (items.nodeName === 'checkoutdata') {
                                var shoppingItems = items.children.item('shopping-cart').children.item('items').children;
                                $("#shopping-cart").find(".api-data").empty();
                                for(j=0; j<shoppingItems.length; j++) {
                                  $.each(shoppingItems[j].children, function(index, el) {
                                    if (el.nodeName === 'item-name') {
                                        $("#shopping-cart").find(".api-data").append("<h3>" + el.nodeName + ": " + el.innerHTML + "</h3><hr>");
                                    } else if (el.hasAttribute('currency')) {
                                        $("#shopping-cart").find(".api-data").append("<p>" + el.nodeName + ": " + el.innerHTML + " " + el.getAttribute('currency') + "</p>");
                                    } else if (el.hasAttribute('unit')) {
                                        $("#shopping-cart").find(".api-data").append("<p>" + el.nodeName + ": " + el.getAttribute('value') + " " + el.getAttribute('unit') + "</p>");
                                    } else {
                                        $("#shopping-cart").find(".api-data").append("<p>" + el.nodeName + ": " + el.innerHTML + "</p>");
                                    }
                                  });
                                };
                            }
                            $("#"+items.nodeName).find(".api-data").append("<p>" + el.nodeName + ": " + el.innerHTML + "</p>");
                        });
                    }
                    $("#my-tab-content").show();
            }

            $( "#button" ).click(function() {
                $.ajax({
                    //url: hostname + "index.php",
                    url: "http://im.codigo4.es/multisafepay/testMultiSafePay/public/index.php/api/order",
                    dataType: "xml",
                    type: 'GET',
                    success: function(data) {
                        addData(data);
                    },
                    error: function() {
                        alert( "Something goes wrong" );
                    }
                });
            });
