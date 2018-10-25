<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('reorder-tab')){
		var reorder = {
			id:'reorder',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/reorder/',
			opcion:'I',
			id_lote:'<?php echo $p["id_lote"];?>',
			shi_codigo:'<?php echo $p["shi_codigo"];?>',
			fac_cliente:'<?php echo $p["fac_cliente"];?>',
			paramsStore:{},
			init:function(){
				Ext.tip.QuickTipManager.init();

				Ext.define('TaskX', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'id_det', type: 'string'},
				        {name: 'lot_estado', type: 'string'},
	                    {name: 'tipdoc', type: 'string'},
	                    {name: 'nombre', type: 'string'},
	                    {name: 'lote_nombre', type: 'string'},
	                    {name: 'descripcion', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'tot_folder', type: 'string'},
	                    {name: 'tot_pag', type: 'string'},
	                    {name: 'tot_errpag', type: 'string'},
	                    {name: 'id_user', type: 'string'},
	                    {name: 'usr_update', type: 'string'},
	                    {name: 'fec_update', type: 'string'},
	                    {name: 'estado', type: 'string'}
				    ]
				});
				var storeTree = new Ext.data.TreeStore({
	                model: 'TaskX',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: reorder.url+'get_list_lotizer/'//,
	                    //reader:{
	                    //    type: 'json'//,
	                    //    //rootProperty: 'data'
	                    //}
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
	                		store.proxy.extraParams = reorder.paramsStore;
					        /*Ext.apply(operation, {
					            params: {
					                to: 'test1',
		    						from: 'test2'
					            }
					       });*/
					    },
	                    load: function(obj, records, successful, opts){
	                 	 	Ext.getCmp(reorder.id + '-grid-reorder').doLayout();
	                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(reorder.id + '-grid-reorder').collapseAll();
		                    Ext.getCmp(reorder.id + '-grid-reorder').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                    });
		                    Ext.getCmp(reorder.id + '-grid-reorder').expandAll();
	                    }
	                }
	            });

				
				var panel = Ext.create('Ext.form.Panel',{
					id:reorder.id+'-form',
					bodyStyle: 'background: transparent',
					border:false,
					layout:'border',
					defaults:{
						border:false
					},
					//tbar:[],
					items:[
						{
							region:'center',
							layout:'fit',
							border:false,
							items:[


								{
			                        xtype: 'treepanel',
			                        //collapsible: true,
							        useArrows: true,
							        rootVisible: true,
							        multiSelect: true,
							        //root:'Task',
			                        id: reorder.id + '-grid-reorder',
			                        //height: 370,
			                        //reserveScrollbar: true,
			                        //rootVisible: false,
			                        //store: store,
			                        //layout:'fit',
			                        columnLines: true,
			                        store: storeTree,
						            columns: [
							            {
							            	xtype: 'treecolumn',
		                                    text: 'Nombre',
		                                    dataIndex: 'lote_nombre',
		                                    sortable: true,
		                                    flex: 1
		                                }
							        ],
			                        /*viewConfig: {
			                            stripeRows: true,
			                            enableTextSelection: false,
			                            markDirty: false
			                        },*/
			                        viewConfig: {
						                plugins: {
						                    ptype: 'treeviewdragdrop',
						                    containerScroll: true
						                },
						                listeners: {
						                	beforedrop: function ( node, data, overModel, dropPosition, dropHandlers,eOpts ){

						                		console.log(node);
						                		console.log(data);
						                		console.log(overModel);
						                		console.log(dropPosition);
						                		console.log(dropHandlers);

						                		var hijox=overModel.parentNode.data.hijo;
												var padrex=overModel.parentNode.data.padre;

												if(dropPosition=='append'){
													hijox=overModel.data.hijo;
													padrex=overModel.data.padre;
												}


												console.log(hijox,padrex);

												var bool = false;
												for(var j=0;j<data.records.length;j++){
													if(dropPosition=='before' && parseInt(data.records[j].data.nivel) ==3 && parseInt(overModel.data.nivel) <= 2){
														bool= true;
													}
													if(dropPosition=='after' && parseInt(data.records[j].data.nivel) ==3 && parseInt(overModel.data.nivel) <= 2){
														bool= true;
													}
													if(dropPosition=='append' && parseInt(data.records[j].data.nivel) ==3 && parseInt(overModel.data.nivel) < 2){
														bool= true;
													}

													if(dropPosition=='append' && parseInt(data.records[j].data.nivel) == 2 && parseInt(overModel.data.nivel) != 1){
														bool= true;
													}
													if(dropPosition=='after' && parseInt(data.records[j].data.nivel) == 2 && parseInt(overModel.data.nivel) != 2){
														bool= true;
													}
													if(dropPosition=='before' && parseInt(data.records[j].data.nivel) == 2 && parseInt(overModel.data.nivel)!= 2){
														bool= true;
													}

													if(dropPosition=='after' && parseInt(overModel.data.nivel) == 1){
														bool= true;
													}
													if(dropPosition=='before' && parseInt(overModel.data.nivel) == 1){
														bool= true;
													}
													if(dropPosition=='append' && parseInt(overModel.data.nivel) == 1){
														bool= true;
													}
													
												}
												//console.log(bool);
												if(bool){
													eOpts.cancel = true;
													return !bool;
												}else{
							                		for(var i=0;i<data.records.length;i++){
														var hijo= data.records[i].data.hijo;
														var padre= data.records[i].data.padre;

														console.log(data.records[0].data);
														console.log('padre',overModel.data);
														
														Ext.getCmp(reorder.id + '-grid-reorder').getStore().each(function(record, idx) {
														    if(parseInt(record.get('hijo'))==parseInt(hijo) && parseInt(record.get('padre'))==parseInt(padre)){
															    //record.set('hijo', hijox);
															    record.set('padre', hijox);
															    record.commit();
														    }
														});
													}
												}
											}
						                }
						            },
			                        /*hideItemsReadFalse: function () {
									    var me = this,items = me.getReferences().treelistRef.itemMap;
									    for(var i in items){
									        if(items[i].config.node.data.read == false){
									            items[i].destroy();
									        }
									    }
									},*/
			                        trackMouseOver: false,
			                        listeners:{
			                            afterrender: function(obj){
			                                //reorder.getImagen('default.png');
			                                /*Ext.getCmp(reorder.id + '-grid-reorder').getStore().removeAll();
											Ext.getCmp(reorder.id + '-grid-reorder').getView().refresh();*/
			                            },
										beforeselect:function(obj, record, index, eOpts ){
											/*reorder.getStatusPanel(record.get('lot_estado'));
											reorder.getHistory(record.get('id_lote'));

											//document.getElementById('imagen-reorder').innerHTML='<img src="'+record.get('path')+record.get('img')+'" width="100%" height="100%" />'
											
											

											var image = document.getElementById('imagen-reorder-img');
											var downloadingImage = new Image();
											downloadingImage.onload = function(){
											    image.src = this.src;   
											    Ext.getCmp(reorder.id + '-panel-imagen').doLayout();
											};
											downloadingImage.src = record.get('path')+record.get('img');*/
										}
			                        }
			                    }
							]
						}
					]
				});

				
				var win = Ext.create('Ext.window.Window',{
					id:reorder.id+'-win',
					title:'RE-ORDENAR',
					height:500,
					width:300,
					resizable:false,
					//closable:false,
					//minimizable:true,
					plaint:true,
					constrain:true,
					constrainHeader:true,
					//renderTo:Ext.get(gtransporte.id+'cont_map'),
					header:true,
					border:false,
					layout:{
						type:'fit'
					},
					modal:true,
					items:[panel],
					bbar:[
						{
			                xtype:'button',
			                flex:1,
			                text: 'Buscar',
			                icon: '/images/icon/save.png',
			                listeners:{
			                    beforerender: function(obj, opts){
			                        /*global.permisos({
			                            id: 15,
			                            id_btn: obj.getId(), 
			                            id_menu: gestion_devolucion.id_menu,
			                            fn: ['panel_asignar_gestion.limpiar']
			                        });*/
			                    },
			                    click: function(obj, e){
			                    	//scanning.setLibera();
							        //scanning.getReloadGridscanning();
			                    }
			                }
			            },
			            {
			                xtype:'button',
			                flex:1,
			                text: 'Buscar',
			                icon: '/images/icon/remove.png',
			                listeners:{
			                    beforerender: function(obj, opts){
			                        /*global.permisos({
			                            id: 15,
			                            id_btn: obj.getId(), 
			                            id_menu: gestion_devolucion.id_menu,
			                            fn: ['panel_asignar_gestion.limpiar']
			                        });*/
			                    },
			                    click: function(obj, e){
			                    	//scanning.setLibera();
							        //scanning.getReloadGridscanning();
			                    }
			                }
			            }
					],
					listeners:{
						show:function(window,eOpts){
							//window.alignTo(Ext.get(gtransporte.id+'Mapsa'),'bl-bl');
						},
						minimize:function(window,opts){
							/*window.collapse();
							window.setWidth(100);
							window.alignTo(Ext.get(gtransporte.id+'Mapsa'), 'bl-bl');*/
						},
						beforerender:function(obj,opts){
							reorder.getReloadGridreorder();
						}
					}
				}).show();
			},
			getReloadGridreorder:function(){
				if(reorder.shi_codigo== null || reorder.shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(reorder.fac_cliente== null || reorder.fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        //Ext.getCmp(reorder.id + '-grid-reorder').getStore().removeAll();
		        //Ext.getCmp(reorder.id + '-grid-reorder').getView().refresh();
		        reorder.paramsStore={vp_shi_codigo:reorder.shi_codigo,vp_fac_cliente:reorder.fac_cliente,vp_lote:reorder.id_lote,vp_lote_estado:'',vp_estado:''};
		        Ext.getCmp(reorder.id + '-grid-reorder').getStore().load(
	                {params: reorder.paramsStore,
	                callback:function(){
	                	//Ext.getCmp(reorder.id+'-form').el.unmask();
	                }
	            });
			},
			setReorder:function(){
				var recordsToSend = [];
				Ext.getCmp(reorder.id + '-grid-reorder').getStore().each(function(record, idx) {
					//console.log(record.data);
					//console.log('padre',record.parentNode.data);
					var hijo= record.get('hijo');
					var padre= record.get('padre');
					var nombre= record.get('nombre');
					var hijo= record.get('hijo');
					recordsToSend.push(Ext.apply({hijo:hijo,padre:padre,nivel:nivel,nombre:nombre},hijo));
				});

				var vp_recordsToSend = Ext.encode(recordsToSend);
				//console.log(recordsToSend);

		    	Ext.Ajax.request({
                    url: reorder.url + 'set_reorder/',
                    params:{
                    	vp_recordsToSend:vp_recordsToSend
                    },
                    success: function(response, options){
                    	Ext.getCmp(control.id+'-form').el.unmask();
                    	control.getLoader(false);
                        var res = Ext.JSON.decode(response.responseText);
                        if (res.error == 'OK'){
                            global.Msg({
                                msg: res.msn,
                                icon: 1,
                                buttons: 1,
                                fn: function(btn){
                                	record.set('ocr', 'Y');
								    //page = record.get('id_pag');
								    record.commit();
                                	control.getReloadPage();
                                }
                            });
                        } else{
                            global.Msg({
                                msg: res.msn,
                                icon: 0,
                                buttons: 1,
                                fn: function(btn){
                                	record.set('ocr', 'N');
								    //page = record.get('id_pag');
								    record.commit();
                                    control.getReloadPage();
                                }
                            });
                        }
                    }
                });
			}
		}
		Ext.onReady(reorder.init,reorder);
	}else{
		tab.setActiveTab(reorder.id+'-tab');
	}
</script>