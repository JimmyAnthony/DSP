<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('reprocessing-tab')){
		var reprocessing = {
			id:'reprocessing',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/reprocessing/',
			opcion:'I',
			//runner: new Ext.util.TaskRunner(),
			work:false,
			id_pag:0,
			shi_codigo:0,
			id_det:0,
			id_lote:0,
			group1:'',
			group2:'',
			trabajando:1,
			init:function(){
				Ext.tip.QuickTipManager.init();
				Ext.Ajax.timeout = 300000;
				/*
				reprocessing.task = reprocessing.runner.newTask({
                    run: function(){
                        reprocessing.getreprocessing();
                    },
                    interval: (1000 * 30)
                });

                reprocessing.task.start();*/

                reprocessing.group1 = reprocessing.id + 'group1';
            	reprocessing.group2 = reprocessing.id + 'group2';

				Ext.define('Task', {
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
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: reprocessing.url+'get_list_lotizer/'//,
	                    //reader:{
	                    //    type: 'json'//,
	                    //    //rootProperty: 'data'
	                    //}
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
					        /*Ext.apply(operation, {
					            params: {
					                to: 'test1',
		    						from: 'test2'
					            }
					       });*/
					    },
	                    load: function(obj, records, successful, opts){
	                 		Ext.getCmp(reprocessing.id + '-grid').doLayout();
	                 		//Ext.getCmp(reprocessing.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(reprocessing.id + '-grid').collapseAll();
		                    Ext.getCmp(reprocessing.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
		                    Ext.getCmp(reprocessing.id + '-grid').expandAll();
	                    }
	                }
	            });
				this.msgTpl = new Ext.Template(
		            'Sounds Effects: <b>{fx}%</b><br />',
		            'Ambient Sounds: <b>{ambient}%</b><br />',
		            'Interface Sounds: <b>{iface}%</b>'
		        );

		        var store = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'estado', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: reprocessing.url+'get_XX/',
	                    reader:{
	                        type: 'json',
	                        rootProperty: 'data'
	                    }
	                },
	                listeners:{
	                    load: function(obj, records, successful, opts){
	                        
	                    }
	                }
	            });

				var store_paginas = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'id_pag', type: 'string'},
	                    {name: 'id_pag_error', type: 'string'},
	                    {name: 'id_det', type: 'string'},
	                    {name: 'id_lote', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'file', type: 'string'},
	                    {name: 'lado', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'include', type: 'string'},
	                    {name: 'msg_error', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: reprocessing.url+'get_load_page/',
	                    reader:{
	                        type: 'json',
	                        rootProperty: 'data'
	                    }
	                },
	                listeners:{
	                    load: function(obj, records, successful, opts){
	                        
	                    }
	                }
	            });
	            var store_tmp = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'id_pag', type: 'string'},
	                    {name: 'id_det', type: 'string'},
	                    {name: 'id_lote', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'file', type: 'string'},
	                    {name: 'lado', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'include', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: reprocessing.url+'get_scanner/',
	                    reader:{
	                        type: 'json',
	                        rootProperty: 'data'
	                    }
	                },
	                listeners:{
	                    load: function(obj, records, successful, opts){
	                        
	                    }
	                }
	            });
				var store_shipper = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'shi_codigo', type: 'string'},
	                    {name: 'shi_nombre', type: 'string'},
	                    {name: 'shi_logo', type: 'string'},
	                    {name: 'fec_ingreso', type: 'string'},                    
	                    {name: 'shi_estado', type: 'string'},
	                    {name: 'id_user', type: 'string'},
	                    {name: 'fecha_actual', type: 'string'}
	                ],
	                autoLoad:true,
	                proxy:{
	                    type: 'ajax',
	                    url: reprocessing.url+'get_list_shipper/',
	                    reader:{
	                        type: 'json',
	                        rootProperty: 'data'
	                    }
	                },
	                listeners:{
	                    load: function(obj, records, successful, opts){
	                        
	                    }
	                }
	            });
            var store_contratos = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'fac_cliente', type: 'string'},
                    {name: 'cod_contrato', type: 'string'},
                    {name: 'pro_descri', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: reprocessing.url+'get_list_contratos/',
                    reader:{
                        type: 'json',
                        rootProperty: 'data'
                    }
                },
                listeners:{
                    load: function(obj, records, successful, opts){
                        
                    }
                }
            });

		    var myDataLote = [
				['A','Activo'],
			    ['I','Inactivo']
			];
			var store_estado_lote = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myDataLote,
		        fields: ['code', 'name']
		    });
			
			var myData = [
			    [1,'Activo'],
			    [0,'Inactivo']
			];
			var store_estado = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myData,
		        fields: ['code', 'name']
		    });

				var panel = Ext.create('Ext.form.Panel',{
					id:reprocessing.id+'-form',
					bodyStyle: 'background: transparent',
					border:false,
					region:'center',
					layout:'border',
					defaults:{
						border:false
					},
					tbar:[],
					items:[
						{
							region:'west',
							id:reprocessing.id + '-panel-west-lote',
							border:true,
							width:400,
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
		                            region:'north',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'BE',
		                            title: 'Panel de Re - proceso',
		                            legend: 'Seleccione el Lote Registrado',
		                            width:385,
		                            height:210,
		                            items:[
		                                {
		                                    xtype:'panel',
		                                    border:false,
		                                    bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',
		                                    items: [
		                                    	{
			                                   		width: 350,border:false,
			                                    	padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                              {
				                                            xtype:'combo',
				                                            fieldLabel: 'Cliente',
				                                            id:reprocessing.id+'-cbx-cliente',
				                                            store: store_shipper,
				                                            queryMode: 'local',
				                                            triggerAction: 'all',
				                                            valueField: 'shi_codigo',
				                                            displayField: 'shi_nombre',
				                                            emptyText: '[Seleccione]',
				                                            labelAlign:'right',
				                                            //allowBlank: false,
				                                            labelWidth: 50,
				                                            width:'100%',
				                                            anchor:'100%',
				                                            //readOnly: true,
				                                            listeners:{
				                                                afterrender:function(obj, e){
				                                                    // obj.getStore().load();
				                                                },
				                                                select:function(obj, records, eOpts){
				                                                	Ext.getCmp(reprocessing.id+'-cbx-contrato').setValue('');
				                                        			reprocessing.getContratos(records.get('shi_codigo'));
				                                                }
				                                            }
				                                        }
			                                 		]
			                                    },
			                                    {
			                                   		width: 350,border:false,
			                                    	padding:'10px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Contrato',
			                                                    id:reprocessing.id+'-cbx-contrato',
			                                                    store: store_contratos,
			                                                    queryMode: 'local',
			                                                    triggerAction: 'all',
			                                                    valueField: 'fac_cliente',
			                                                    displayField: 'pro_descri',
			                                                    emptyText: '[Seleccione]',
			                                                    labelAlign:'right',
			                                                    //allowBlank: false,
			                                                    labelWidth: 50,
			                                                    width:'100%',
			                                                    anchor:'100%',
			                                                    //readOnly: true,
			                                                    listeners:{
			                                                        afterrender:function(obj, e){
			                                                            // obj.getStore().load();
			                                                        },
			                                                        select:function(obj, records, eOpts){ 
			                                                			
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
			                                    {
		                                            width:350,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'N° Lote',
		                                                    id:reprocessing.id+'-txt-lote',
		                                                    labelWidth:50,
		                                                    maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
		                                            width:350,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre',
		                                                    id:reprocessing.id+'-txt-reprocessing',
		                                                    labelWidth: 50,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
			                                        width: 350,border:false,
			                                        padding:'0px 2px 5px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                    	layout:'column',
			                                        items:[
			                                            {
			                                                xtype:'datefield',
			                                                id:reprocessing.id+'-txt-fecha-filtro',
			                                                padding:'0px 10px 0px 0px',  
			                                                fieldLabel:'Fecha',
			                                                labelWidth: 50,
			                                                labelAlign:'right',
			                                                value:new Date(),
			                                                format: 'Ymd',
			                                                //readOnly:true,
			                                                width: 187,
			                                                anchor:'100%'
			                                            },
			                                            {
									                        xtype:'button',
									                        width:100,
									                        text: 'Buscar',
									                        icon: '/images/icon/binocular.png',
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
									                            	reprocessing.setLibera();
		                               					            reprocessing.getReloadGridreprocessing();
									                            }
									                        }
									                    }
			                                        ]
			                                    }
		                                    ]
		                                }
		                            ]
		                        },
								{
									region:'center',
									layout:'border',
									border:true,
									padding:'5px 5px 5px 5px',
									items:[
										{
											region:'center',
											border:false,
											layout:'fit',
											items:[
												{
							                        xtype: 'treepanel',
							                        //collapsible: true,
											        useArrows: true,
											        rootVisible: true,
											        multiSelect: true,
											        //root:'Task',
							                        id: reprocessing.id + '-grid',
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
						                                    renderer: reprocessing.renderTip,
						                                    sortable: true,
						                                    flex: 1
						                                },
						                                /*{
						                                    text: 'Estado Lote',
						                                    dataIndex: 'lot_estado',
						                                    loocked : true,
						                                    width: 100,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        metaData.style = "padding: 0px; margin: 0px";
						                                        if(parseInt(record.get('nivel'))==1){
							                                        var estado = (record.get('lot_estado')=='LT')?'baggage_cart_box.png':'contraer.png';
							                                        var qtip = (record.get('lot_estado')=='LT')?'Lotizado.':'Lote en otro Estado.';
						                                        }else{
						                                        	var estado = (record.get('lot_estado')=='LT')?'basket_put_gray.png':'basket_put.png';
							                                        var qtip = (record.get('lot_estado')=='LT')?'Folder Vacio.':'Folder en otro Estado.';
						                                        }
						                                        

						                                        return global.permisos({
						                                            type: 'link',
						                                            id_menu: reprocessing.id_menu,
						                                            icons:[
						                                                {id_serv: 1, img: estado, qtip: qtip, js: ""}
						                                            ]
						                                        });
						                                    }
						                                },*/
						                                {
						                                    text: 'Folders',
						                                    dataIndex: 'tot_folder',
						                                    width: 45,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Páginas',
						                                    dataIndex: 'tot_pag',
						                                    width: 50,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Error',
						                                    dataIndex: 'tot_errpag',
						                                    width: 50,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Cerrar',
						                                    dataIndex: 'estado',
						                                    //loocked : true,
						                                    width: 50,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        if(parseInt(record.get('nivel')) == 1){
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        var shi_codigo=record.get('shi_codigo');
							                                        var id_lote=record.get('id_lote');
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: reprocessing.id_menu,
							                                            icons:[
							                                                {id_serv: 4, img: '1315404769_gear_wheel.png', qtip: 'Cerrar Escaneado.', js: "reprocessing.setCerrarEscaneado("+shi_codigo+","+id_lote+")"}
							                                            ]
							                                        });
							                                    }else{
						                                        	return '';
						                                        }
						                                    }
						                                }
											        ],
							                        /*viewConfig: {
							                            stripeRows: true,
							                            enableTextSelection: false,
							                            markDirty: false
							                        },*/
							                        hideItemsReadFalse: function () {
													    var me = this,
													        items = me.getReferences().treelistRef.itemMap;


													    for(var i in items){
													        if(items[i].config.node.data.read == false){
													            items[i].destroy();
													        }
													    }
													},
							                        trackMouseOver: false,
							                        listeners:{
							                            afterrender: function(obj){
							                                //reprocessing.getImagen('default.png');
							                                
							                            },
														beforeselect:function(obj, record, index, eOpts ){
															reprocessing.shi_codigo=record.get('shi_codigo');
															reprocessing.id_det=record.get('id_det');
															reprocessing.id_lote=record.get('id_lote');
															reprocessing.getLiberaPanel();
														}
							                        }
							                    }
											]
										},
										{
											region:'south',
<<<<<<< HEAD
=======
											hidden:false,
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
											height:370,
											border:false,
											items:[
												{
											        xtype: 'fieldset',
											        title: 'Acción',
											        margin:'5px 5px 5px 5px',
											        defaults: {
											            anchor: '100%'
											        },
											        layout: 'hbox',
											        items: [
											            {
										                    xtype: 'button',
										                    icon: '/images/icon/if_network-workgroup_118928.png',
										                    flex:1,
										                    //glyph: 72,
										                    scale: 'large',
										                    margin:'5px 5px 5px 5px',
										                    //height:50
										                    text: 'Digitalizar',
										                    //iconAlign: 'top'
										                },
										                {
										                    xtype: 'button',
										                    icon: '/images/icon/if_document-save-as_118915.png',
										                    flex:1,
										                    //glyph: 72,
										                    scale: 'large',
										                    margin:'5px 5px 5px 5px',
										                    //height:50
										                    text: 'Importar',
										                    //iconAlign: 'top'
										                },
											        ]
											    },
											    {
											        xtype: 'fieldset',
											        title: 'Escáner',
											        margin:'5px 5px 5px 5px',
											        defaults: {
											            anchor: '100%'
											        },
											        items: [
											        	{
											        		xtype:'panel',
											        		layout: 'hbox',
											        		items:[
											        			{
														            xtype: 'filefield',
														            //buttonOnly: true,
														            width: '75%',
														            anchor: '100%',
														            buttonText:'Seleccionar',
														            hideLabel: true,
														            margin:'5px 5px 5px 5px',
														            reference: 'basicFile'
														        },
												                {
													                xtype: 'checkbox',
													                boxLabel: 'Duplex',
													                margin:'5px 5px 5px 5px',
													                listeners: {
													                }
													            }
											        		]
											        	},
											            {
												            xtype: 'combobox',
												            margin:'5px 5px 5px 5px',
												            reference: 'states',
												            publishes: 'value',
												            fieldLabel: 'Modo',
												            displayField: 'state',
												            anchor: '-15',
												            store: store,
												            minChars: 0,
												            queryMode: 'local',
												            typeAhead: true
												        },
											            {
												            xtype: 'combobox',
												            margin:'5px 5px 5px 5px',
												            reference: 'states',
												            publishes: 'value',
												            fieldLabel: 'Resolución',
												            displayField: 'state',
												            anchor: '-15',
												            store: store,
												            minChars: 0,
												            queryMode: 'local',
												            typeAhead: true
												        },
												        {
															xtype: 'sliderfield',
															margin:'10px 5px 5px 5px',
															fieldLabel: 'Brillo',
															itemId: 'UpdatingSliderField',
															name: 'integer_value',
															value: [
																2
															],
															minValue: 0,
															maxValue: 100,
															listeners:{
										                        change:function(slider,value){
										                        }
										                    }
														},
														{
															xtype: 'sliderfield',
															margin:'10px 5px 5px 5px',
															fieldLabel: 'Contraste',
															itemId: 'UpdatingSliderField2',
															name: 'integer_value2',
															value: [
																2
															],
															minValue: 0,
															maxValue: 100,
															listeners:{
										                        change:function(slider,value){
										                        }
										                    }
														},


											        ]
											    },
											    {
											        xtype: 'fieldset',
											        title: 'Valores',
											        margin:'5px 5px 5px 5px',
											        defaults: {
											            anchor: '100%'
											        },
											        items: [
											    		{
												            xtype: 'filefield',
												            emptyText: 'Directorio de Destino',
												            fieldLabel: 'Destino',
												            name: 'photo-path',
												            buttonText: '',
												            buttonConfig: {
												                iconCls: 'upload-icon'
												            }
												        },
												        {
												            xtype: 'textfield',
												            fieldLabel: 'Nombre del Fichero'
												        },
												        {
												            xtype: 'combobox',
												            //margin:'5px 5px 5px 5px',
												            reference: 'states',
												            publishes: 'value',
												            fieldLabel: 'Select formato',
												            displayField: 'state',
												            anchor: '100%',
												            store: store,
												            minChars: 0,
												            queryMode: 'local',
												            typeAhead: true
												        }
												    ]
												}
											]
										}
									]
								}
							]
						},
						{
							region:'center',
							id:reprocessing.id + '-panel-centrar-paginas',
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'west',
									width:360,
									layout:'border',
									border:true,
									padding:'5px 5px 5px 5px',
									items:[
										{
											region:'north',
											border:true,
											height:60,
											padding:'5px 5px 5px 5px',
											bodyStyle: 'background: transparent',
											layout: 'hbox',
											items:[
												{
								                    xtype: 'button',
								                    icon: '/images/icon/if_edit-delete_118920.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Eliminar Escaneado',
								                    style : {'font-weight' : 'bold'},
								                    listeners:{
								                    	afterrender:function(obj){
								                    		obj.setStyle({'font-weight' : 'bold'});
								                    	},
								                    	click: function(obj, e){
							                            	reprocessing.setRemoveEscaner(true,'');
							                            }
								                    }
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    id:reprocessing.id + '-btn-total',
								                    icon: '/images/icon/if_update_678134.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Total(0)',
								                    style : {'font-weight' : 'bold'},
								                    listeners:{
								                    	afterrender:function(obj){
								                    		obj.setStyle({'font-weight' : 'bold'});
								                    	},
								                    	click: function(obj, e){
							                            	reprocessing.getreprocessingFile();
							                            }
								                    }
								                    //iconAlign: 'top'
								                }
											]
										},
										{
											region:'center',
											layout:'border',
											border:true,
											//padding:'5px 5px 5px 5px',
											tbar:[
												{
									                 xtype : 'progressbar',
									                 id:reprocessing.id + '-progressbar',
									                 itemId : 'progressbar_searchresults',
									                 width : '99%',
									                 /*style: {
									                     color: 'green'
									                 },*/
									                 hidden : true,
									                 //textEl : 'progressbar_textElement',
									                 listeners:{
									                 	update:function(obj){
													        //You can handle this event at each progress interval if
													        //needed to perform some other action
													       	//Ext.fly('p3text').dom.innerHTML += '.';
													       	var punto='.';
													       	if(reprocessing.trabajando==2){
													       		punto='..';
													       	}else if(reprocessing.trabajando==3){
													       		punto='...';
													       		reprocessing.trabajando=0;
													       	}
													       	reprocessing.trabajando+=1;
													       	obj.setTextTpl('Trabajando '+punto); 
													    }
									                 }
									             }
											],
											items:[
												{
<<<<<<< HEAD
=======
													region:'north',
													bodyStyle: 'background: transparent',
													border:false,
													padding:'5px 5px 5px 5px',
													height:40,
													items:[
														{
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Origen de archivos',
		                                                    id:reprocessing.id+'-txt-origen',
		                                                    labelWidth:120,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    //labelAlign:'right',
		                                                    value:'C:/twain/',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
													]
												},
												{
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
													region:'center',
													border:false,
													layout:'fit',
													items:[
														{
									                        xtype: 'grid',
									                        itemId: 'grid1',
									                        id: reprocessing.id + '-grid-paginas-tmp',
									                        store: store_tmp,
									                        columnLines: true,
									                        columns:{
									                            items:[
									                            	{
									                            		text: 'N°',
																	    xtype: 'rownumberer',
																	    width: 30,
																	    sortable: false,
																	    locked: true
																	},
																	{
									                                    text: 'IMG',
									                                    dataIndex: 'estado',
									                                    //loocked : true,
									                                    width: 80,
									                                    align: 'center',
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        //console.log(record);
									                                        metaData.style = "padding: 0px; margin: 0px";
									                                        return '<div class="gk-column-icon"><img src="/tumblr/' + record.get('file') + '" class="link" data-qtip="Vista Previa" onclick=""/></div>';
									                                    }
									                                },
									                                {
									                                    text: 'Descripción',
									                                    dataIndex: 'file',
<<<<<<< HEAD
									                                    flex: 1
=======
									                                    width: 170
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
									                                },/*
									                                {
									                                    text: 'Lado',
									                                    dataIndex: 'flag',
									                                    width: 50
									                                },*/
									                                {
									                                    text: 'DLT',
									                                    dataIndex: 'estado',
									                                    //loocked : true,
									                                    width: 40,
									                                    align: 'center',
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        //console.log(record);
									                                        metaData.style = "padding: 0px; margin: 0px";
									                                        return global.permisos({
									                                            type: 'link',
									                                            id_menu: reprocessing.id_menu,
									                                            icons:[
									                                                {id_serv: 4, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "reprocessing.setRemoveEscaner(false,'"+record.get('file')+"')"}

									                                            ]
									                                        });
									                                    }
									                                }
									                            ],
									                            defaults:{
									                                menuDisabled: true
									                            }
									                        },
									                        multiSelect: true,
									                        viewConfig: {
									                            stripeRows: true,
									                            enableTextSelection: false,
									                            markDirty: false,
									                            plugins: {
				                                                    ptype: 'gridviewdragdrop',
				                                                    containerScroll: true,
				                                                    dragGroup: reprocessing.group1,
                    												dropGroup: reprocessing.group2
				                                                },
				                                                listeners: {
				                                                    drop: function(node, data, dropRec, dropPosition) {
				                                                        var dropOn = dropRec ? ' ' + dropPosition + ' ' + dropRec.get('name') : ' on empty view';
				                                                        //Ext.msg('Drag from right to left', 'Dropped ' + data.records[0].get('name') + dropOn);
				                                                    },
				                                                    beforedrop: function(node, data, dropRec, dropPosition) {
				                                                          /*Ext.Array.each(data.records, function(rec) {
				                                                                rec.setDirty();
				                                                          });*/
				                                                    }
				                                                }
                                            
									                        },
									                        trackMouseOver: false,
									                        listeners:{
									                            afterrender: function(obj){
									                                
									                            },
									                            beforeselect:function(obj, record, index, eOpts ){
									                            	reprocessing.setImageFile(record.get('path'),record.get('file'));
									                            }
									                        }
									                    }
													]
												},
												{
													region:'south',
													id:reprocessing.id+'-panel-paginas',
													//disabled:true,
													split:true,
													layout:'fit',
													height:'50%',
													tbar:[
														{
									                        xtype:'button',
									                        id:reprocessing.id+'-btn-asignar',
									                        disabled:true,
									                        scale: 'large',
									                        //iconAlign: 'top',
									                        //disabled:true,
									                        width:'99%',
		                                                    anchor:'99%',
									                        text: 'Asignar todas las Páginas',
									                        icon: '/images/icon/if_icon-92-inbox-download_314776.png',
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
									                            	//reprocessing.work=!reprocessing.work;
									                            	reprocessing.getreprocessing();
									                            }
									                        }
									                    }
													],
													bbar:[
														{
									                        xtype:'button',
									                        id:reprocessing.id+'-btn-reordenar',
									                        disabled:true,
									                        scale: 'large',
									                        //iconAlign: 'top',
									                        //disabled:true,
									                        flex:1,
									                        text: 'Reordenar(N)',
									                        icon: '/images/icon/if_stock_reverse-order_94695.png',
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
									                            	//reprocessing.work=!reprocessing.work;
									                            }
									                        }
									                    },
									                    {
										                    xtype: 'button',
										                    icon: '/images/icon/if_edit-delete_118920.png',
										                    flex:1,
										                    //glyph: 72,
										                    scale: 'large',
										                    margin:'5px 5px 5px 5px',
										                    //height:50
										                    text: 'Eliminar Todo',
										                    style : {'font-weight' : 'bold'},
										                    listeners:{
										                    	afterrender:function(obj){
										                    		obj.setStyle({'font-weight' : 'bold'});
										                    	},
										                    	click: function(obj, e){
									                            	reprocessing.setRemoveFile(0,true);
									                            }
										                    }
										                    //iconAlign: 'top'
										                }
													],
													items:[
														{
									                        xtype: 'grid',
									                        id: reprocessing.id + '-grid-paginas',
									                        disabled:true,
									                        store: store_paginas,
									                        columnLines: true,
									                        columns:{
									                            items:[
									                            	{
									                            		text: 'N°',
																	    xtype: 'rownumberer',
																	    width: 40,
																	    sortable: false,
																	    locked: true
																	},
									                                /*{
									                                    text: 'Lado',
									                                    dataIndex: 'flag',
									                                    width: 50
									                                },*/
									                                {
									                                    text: 'IMG',
									                                    dataIndex: 'file',
									                                    //loocked : true,
									                                    width: 80,
									                                    align: 'center',
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        //console.log(record);
									                                        metaData.style = "padding: 0px; margin: 0px";
									                                        return '<div class="gk-column-icon"><img src="/tumblr/' + record.get('file') + '" class="link" data-qtip="Vista Previa" onclick=""/></div>';
									                                    }
									                                },
									                                {
									                                    text: 'Descripción',
									                                    dataIndex: 'file',
<<<<<<< HEAD
									                                    flex: 1
=======
									                                    width: 170
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
									                                },
									                                {
									                                    text: 'OPT',
									                                    dataIndex: 'estado',
									                                    //loocked : true,
									                                    width: 50,
									                                    align: 'center',
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        //console.log(record);
									                                        metaData.style = "padding: 0px; margin: 0px";
									                                        var ico =  (parseInt(record.get('id_pag_error'))==0)?'ER_R.png':'ER_E.png';
							                                        		var msn = (parseInt(record.get('id_pag_error'))==0)?'Sin Mensaje Reprocesar':'Mensaje Reprocesar:'+record.get('msg_error');

									                                        return global.permisos({
									                                            type: 'link',
									                                            id_menu: reprocessing.id_menu,
									                                            icons:[
									                                                {id_serv: 4, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "reprocessing.setRemoveFile("+rowIndex+",false)"},
									                                                {id_serv: 4, img: ico, qtip: msn, js: "reprocessing.setMSGREPRO("+rowIndex+")"}

									                                            ]
									                                        });
									                                    }
									                                }
									                            ],
									                            defaults:{
									                                menuDisabled: true
									                            }
									                        },
									                        multiSelect: true,
									                        viewConfig: {
									                            stripeRows: true,
									                            enableTextSelection: false,
									                            markDirty: false,
									                            plugins: {
				                                                    ptype: 'gridviewdragdrop',
				                                                    containerScroll: true,
				                                                    dragGroup: reprocessing.group1,
                    												dropGroup: reprocessing.group1,
				                                                },
				                                                listeners: {
				                                                    drop: function(node, data, dropRec, dropPosition) {
				                                                        var dropOn = dropRec ? ' ' + dropPosition + ' ' + dropRec.get('name') : ' on empty view';
				                                                        //Ext.msg('Drag from left to right', 'Dropped ' + data.records[0].get('name') + dropOn);
				                                                    },
				                                                    beforedrop: function ( node, data, overModel, dropPosition, dropHandlers ) {
				                                                    	console.log(node);
				                                                    	console.log(data);
				                                                    	console.log(data.records);
				                                                    	console.log(overModel);
				                                                    	console.log(dropPosition);
				                                                    	console.log(dropHandlers);
				                                                    	//return true;
				                                                    	reprocessing.getLoader(true);
				                                                    	var recordsToSend = [];
				                                                    	Ext.each(data.records, function (record,i) {
				                                                    		console.log(record.data.file);
				                                                    		recordsToSend.push(Ext.apply({file:record.data.file},record.data));
				                                                    	});
				                                                    	recordsToSend = Ext.encode(recordsToSend);

				                                                    	Ext.getCmp(reprocessing.id+'-form').el.mask('Registrando Páginas…', 'x-mask-loading'); 
<<<<<<< HEAD
=======
				                                                    	var destino=Ext.getCmp(reprocessing.id+'-txt-origen').getValue();
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
											                            Ext.Ajax.request({
											                                url:reprocessing.url+'set_scanner_file_one_to_one/',
											                                params:{
											                                	vp_op:'I',
														                    	vp_shi_codigo:reprocessing.shi_codigo,
														                    	vp_id_pag:0,
														                    	vp_id_det:reprocessing.id_det,
														                    	vp_id_lote:reprocessing.id_lote,
<<<<<<< HEAD
														                    	path:'C:/twain/',
=======
														                    	path:destino,
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
														                    	vp_estado:'A',
											                                    vp_recordsToSend:recordsToSend
											                                },
											                                timeout: 300000,
											                                success: function(response, options){
											                                    Ext.getCmp(reprocessing.id+'-form').el.unmask();
											                                    var res = Ext.JSON.decode(response.responseText);
											                                    reprocessing.getLoader(false);
											                                    if (res.error == 'OK'){
														                            global.Msg({
														                                msg: res.msn,
														                                icon: 1,
														                                buttons: 1,
														                                fn: function(btn){
														                                	reprocessing.getReloadPage();
														                                	reprocessing.getreprocessingFile();
														                                	reprocessing.getReloadGridreprocessing();
														                                }
														                            });
														                        } else{
														                            global.Msg({
														                                msg: res.msn,
														                                icon: 0,
														                                buttons: 1,
														                                fn: function(btn){
														                                	reprocessing.getReloadPage();
														                                    reprocessing.getreprocessingFile();
														                                    reprocessing.getReloadGridreprocessing();
														                                }
														                            });
														                        }
											                                }
											                            });
				                                                        
				                                                    }
				                                                }
                                            
									                        },
									                        trackMouseOver: false,
									                        listeners:{
									                            afterrender: function(obj){
									                                
									                            },
									                            beforeselect:function(obj, record, index, eOpts ){
									                            	reprocessing.id_pag=record.get('id_pag');
									                            	reprocessing.setImageFile(record.get('path'),record.get('file'));
									                            }
									                        }
									                    }
													]
												}
											]
										}
									]
								},
								{
									region:'center',
									border:false,
									layout:'border',
									items:[
										{
											region:'north',
											hidden:true, 
											border:true,
											height:60,
											padding:'5px 20px 5px 20px',
											bodyStyle: 'background: transparent',
											layout: 'hbox',
											items:[
												{
								                    xtype: 'button',
								                    icon: '/images/icon/if_69_111122.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Zoom(+)'
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: '/images/icon/if_68_111123.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Zoom(-)'
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: '/images/icon/if_153_111058.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Máximizar',
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: '/images/icon/if_152_111059.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Minimizar',
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: '/images/icon/if_icons_update_1564533.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Rotar'
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: '/images/icon/if_24_111010.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Guardar'
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: '/images/icon/if_90_111056.png',
								                    flex:1,
								                    scale: 'large',
								                    //glyph: 72,
								                    margin:'5px 5px 5px 5px',
								                    //text: '[Delete]',
								                    text: 'Eliminar'
								                    //iconAlign: 'top'
								                },
								                {
								                    xtype: 'button',
								                    icon: '/images/icon/if_122_111086.png',
								                    flex:1,
								                    //glyph: 72,
								                    scale: 'large',
								                    margin:'5px 5px 5px 5px',
								                    //height:50
								                    text: 'Cortar'
								                    //iconAlign: 'top'
								                }
											]
										},
										{
											region:'center',
											id: reprocessing.id+'-panel_img',
											border:true,
											autoScroll:true,
											padding:'5px 5px 5px 5px',
											html: '<img src="" style="width:100%;" >'
										}
									]
								}
							]
						}
					]
				});
				tab.add({
					id:reprocessing.id+'-tab',
					border:false,
					autoScroll:true,
					closable:true,
					layout:{
						type:'border'
					},
					items:[
						panel
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(reprocessing.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,reprocessing.id_menu);
	                        reprocessing.setImageFile('/reprocessing/','escaneado');
	                        reprocessing.getreprocessingFile();
	                        
	                        //TMP
							/*reprocessing.shi_codigo=1;
							reprocessing.id_det=1;
							reprocessing.id_lote=1;
							reprocessing.getLiberaPanel();*/
						
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(reprocessing.id_menu, false);
	                    }
					}

				}).show();
			},
			setMSGREPRO:function(index){
				var rec = Ext.getCmp(reprocessing.id + '-grid-paginas').getStore().getAt(index);
                var msg=msg= rec.data.msg_error;

                Ext.create('Ext.window.Window',{
	                id:reprocessing.id+'-win-form',
	                plain: true,
	                title:'MSG Reproceso',
	                icon: '/images/icon/ER_E.png',
	                height: 200,
	                width: 450,
	                resizable:false,
	                modal: true,
	                border:false,
	                closable:true,
	                padding:20,
	                layout:'fit',
	                items:[
	                	{
                            xtype: 'textarea',
                            //fieldLabel: 'Texto',
                            id:reprocessing.id+'-txt-texto-reproceso',
                            labelWidth:0,
                            //maskRe: /[0-9]/,
                            //readOnly:true,
                            value:msg,
                            labelAlign:'right',
                            width:'100%',
                            anchor:'100%'
                        }
	                ],
	                bbar:[
	                    '->',
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Corregir',
	                        icon: '/images/icon/save.png',
	                        listeners:{
	                            beforerender: function(obj, opts){
								},
	                            click: function(obj, e){
	                            	reprocessing.setSaveReproFile('C',index);
	                            }
	                        }
	                    },
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Salir',
	                        icon: '/images/icon/get_back.png',
	                        listeners:{
	                            beforerender: function(obj, opts){
	                            },
	                            click: function(obj, e){
	                                Ext.getCmp(reprocessing.id+'-win-form').close();
	                            }
	                        }
	                    },
	                    '-'
	                ],
	                listeners:{
	                    'afterrender':function(obj, e){ 

	                    },
	                    'close':function(){

	                    }
	                }
	            }).show().center();
			},
			setSaveReproFile:function(op,index){
				var rec = Ext.getCmp(reprocessing.id + '-grid-paginas').getStore().getAt(index);
				var id_pag=rec.data.id_pag;
                var id_det=rec.data.id_det;
                var id_lote=rec.data.id_lote; 

		    	var msn=Ext.getCmp(reprocessing.id+'-txt-texto-reproceso').getValue();

				if(parseInt(id_det)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(id_lote)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(id_pag)==0){
					global.Msg({msg:"Seleccione una página.",icon:2,fn:function(){}});
					return false;
				}
				if(msn==''){
					global.Msg({msg:"Ingrese un mensaje para la página con error.",icon:2,fn:function(){}});
					return false;
				}

				global.Msg({
                    msg: '¿Guardando configuración?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(reprocessing.id+'-win-form').el.mask('Actualizando Página…', 'x-mask-loading');
	                        reprocessing.getLoader(true);
			                Ext.Ajax.request({
			                    url:reprocessing.url+'setSaveReproFile/',
			                    params:{
			                    	vp_op:op,
			                    	vp_id_pag:id_pag,
			                    	vp_id_det:id_det,
			                    	vp_id_lote:id_lote,
			                    	vp_msn:msn
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                        Ext.getCmp(reprocessing.id+'-win-form').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        reprocessing.getLoader(false);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	reprocessing.getReloadPage();
			                                	Ext.getCmp(reprocessing.id+'-win-form').close();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                	//control.getReloadPage();
			                                }
			                            });
			                        }
			                    }
			                });
						}
					}
				});
			},
			setCerrarEscaneado:function(shi_codigo,id_lote){
				if(parseInt(shi_codigo)==0){ 
					global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(id_lote)==0){
					global.Msg({msg:"Seleccione un Lote.",icon:2,fn:function(){}});
					return false;
				}

				global.Msg({
                    msg: '¿Seguro de enviar el Lote a Control?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(reprocessing.id+'-form').el.mask('Cerrando Lote…', 'x-mask-loading');
	                        reprocessing.getLoader(true);
			                Ext.Ajax.request({
			                    url:reprocessing.url+'set_lotizer/',
			                    params:{
			                    	vp_op:'C',
			                    	vp_shi_codigo:shi_codigo,
			                    	vp_id_lote:id_lote
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                        Ext.getCmp(reprocessing.id+'-form').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        reprocessing.getLoader(false);
			                        
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	reprocessing.setLibera();
			                                	reprocessing.getReloadGridreprocessing();
			                                	//reprocessing.getreprocessingFile();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                	//reprocessing.getReloadGridreprocessing();
			                                    //reprocessing.getreprocessingFile();
			                                }
			                            });
			                        }
			                    }
			                });
						}
					}
				});

			},
			setChangeRow:function(){
				var count = Ext.getCmp(reprocessing.id + '-grid-paginas').getStore().getCount();
				Ext.getCmp(reprocessing.id + '-grid').getStore().each(function(record, idx) {
				    val = record.get('id_det');
				    if(reprocessing.id_det==parseInt(val)){
					    record.set('tot_pag', count); 
					    record.commit();
				    }
				});
			},
			setRemoveFile:function(index,bool){
				if(!bool){
					var rec = Ext.getCmp(reprocessing.id + '-grid-paginas').getStore().getAt(index);
					reprocessing.id_pag=rec.data.id_pag; 
	                reprocessing.id_det=rec.data.id_det; 
	                reprocessing.id_lote=rec.data.id_lote; 
				}
				if(parseInt(reprocessing.shi_codigo)==0){ 
					global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(reprocessing.id_det)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(reprocessing.id_lote)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(!bool){
					if(parseInt(reprocessing.id_pag)==0){
						global.Msg({msg:"Seleccione una página.",icon:2,fn:function(){}});
						return false;
					}
				}

				
				global.Msg({
                    msg: '¿Seguro de eliminar página(s)?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(reprocessing.id+'-form').el.mask('Elinando Páginas…', 'x-mask-loading');
	                        reprocessing.getLoader(true);
			                Ext.Ajax.request({
			                    url:reprocessing.url+'set_remove_file/',
			                    params:{
			                    	vp_op:'D',
			                    	vp_shi_codigo:reprocessing.shi_codigo,
			                    	vp_id_pag:(bool)?0:reprocessing.id_pag,
			                    	vp_id_det:reprocessing.id_det,
			                    	vp_id_lote:reprocessing.id_lote
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                        Ext.getCmp(reprocessing.id+'-form').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        reprocessing.getLoader(false);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	reprocessing.getReloadGridreprocessing();
			                                	reprocessing.getReloadPage();
			                                	//reprocessing.getreprocessingFile();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                	reprocessing.getReloadGridreprocessing();
			                                	reprocessing.getReloadPage();
			                                    //reprocessing.getreprocessingFile();
			                                }
			                            });
			                        }
			                    }
			                });
						}
					}
				});
			},
			getReloadPage:function(){
				reprocessing.id_pag=0;
				Ext.getCmp(reprocessing.id + '-grid-paginas').getStore().removeAll();
				Ext.getCmp(reprocessing.id + '-grid-paginas').getStore().load({
                	params:{
                		vp_id_pag:0,
                		vp_shi_codigo:reprocessing.shi_codigo,
                    	vp_id_det:reprocessing.id_det,
                    	vp_id_lote:reprocessing.id_lote
	                },
	                callback:function(){
	                	//Ext.getCmp(reprocessing.id+'-form').el.unmask();
	                	//reprocessing.setChangeRow();
	                }
	            });
			},
			setRemoveEscaner:function(bool,file){
				var url =(bool)?'/set_remove_scanner_file/':'/set_remove_scanner_file_one/';
				var msn =(bool)?'¿Seguro de Eliminar las hojas escaneadas?':'¿Seguro de Eliminar la hoja escaneada?';
<<<<<<< HEAD
=======
				var destino=Ext.getCmp(reprocessing.id+'-txt-origen').getValue();
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
				global.Msg({
                    msg: msn,
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        reprocessing.getLoader(true);

	                        Ext.Ajax.request({
			                    url: reprocessing.url+url,
			                    params:{
<<<<<<< HEAD
			                    	path:'C:/twain/',
=======
			                    	path:destino,
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
			                    	file:file
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                    	reprocessing.getreprocessingFile();

			                        //var res = Ext.JSON.decode(response.responseText);
			                        //reprocessing.work=!reprocessing.work;
			                        console.log(response);
			                        /*if (parseInt(res.time) == 0 ){
			                            reprocessing.task.stop();
			                            global.Msg({
			                                msg: 'Su sesión de usuario ha caducado, volver a ingresar al sistema.',
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                    window.location = '/inicio/index/'
			                                }
			                            });
			                        }*/
			                    }
			                });
						}
		            }
                });
			},
			getLoader:function(bool){
				if(bool){
					Ext.getCmp(reprocessing.id + '-progressbar').show();
					Ext.getCmp(reprocessing.id + '-progressbar').wait({
			            interval: 200,
			            //duration: 5000,
			            increment: 15,
			            fn:function() {
			                //btn3.dom.disabled = false;
			                //Ext.fly('p3text').update('Done');

			            }
			        });
				}else{
					Ext.getCmp(reprocessing.id + '-progressbar').setTextTpl('Finalizado'); 
					Ext.getCmp(reprocessing.id + '-progressbar').hide();
				}
			},

			getreprocessingFile:function(){
				reprocessing.getLoader(true);
<<<<<<< HEAD
				Ext.getCmp(reprocessing.id + '-grid-paginas-tmp').getStore().removeAll();
				Ext.getCmp(reprocessing.id + '-grid-paginas-tmp').getStore().load(
	                {params: {path:'C:/twain/'},
=======
				var destino=Ext.getCmp(reprocessing.id+'-txt-origen').getValue();
				Ext.getCmp(reprocessing.id + '-grid-paginas-tmp').getStore().removeAll();
				Ext.getCmp(reprocessing.id + '-grid-paginas-tmp').getStore().load(
	                {params: {path:destino},
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
	                callback:function(){
	                	//Ext.getCmp(reprocessing.id+'-form').el.unmask();
	                	reprocessing.getLoader(false);
	                	var count = Ext.getCmp(reprocessing.id + '-grid-paginas-tmp').getStore().getCount();
	                	Ext.getCmp(reprocessing.id + '-btn-total').setText('Total('+count+')');
	                }
		        });
			},
			getreprocessing:function(){
				if(parseInt(reprocessing.shi_codigo)==0){ 
					return false;
				}
				if(parseInt(reprocessing.id_det)==0){
					return false;
				}
				if(parseInt(reprocessing.id_lote)==0){
					return false;
				}
				console.log(reprocessing.shi_codigo+'-'+reprocessing.id_det+'-'+reprocessing.id_lote);
<<<<<<< HEAD
=======
				var destino=Ext.getCmp(reprocessing.id+'-txt-origen').getValue();
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6

				global.Msg({
                    msg: 'Seguro de Asignar todas las Páginas?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(reprocessing.id+'-form').el.mask('Registrando Páginas…', 'x-mask-loading'); 
							reprocessing.getLoader(true);
							Ext.Ajax.request({
			                    url: reprocessing.url+'/get_scanner_file/',
			                    params:{
			                    	vp_op:'I',
			                    	vp_shi_codigo:reprocessing.shi_codigo,
			                    	vp_id_pag:0,
			                    	vp_id_det:reprocessing.id_det,
			                    	vp_id_lote:reprocessing.id_lote,
<<<<<<< HEAD
			                    	path:'C:/twain/',
=======
			                    	path:destino,
>>>>>>> b7dc362f30827bd90f8309a842aabc85f825b1b6
			                    	vp_estado:'A'
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
                                    Ext.getCmp(reprocessing.id+'-form').el.unmask();
                                    var res = Ext.JSON.decode(response.responseText);
                                    reprocessing.getLoader(false);
                                    if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	reprocessing.getReloadPage();
			                                	reprocessing.getreprocessingFile();
			                                	reprocessing.getReloadGridreprocessing();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                	reprocessing.getReloadPage();
			                                    reprocessing.getreprocessingFile();
			                                    reprocessing.getReloadGridreprocessing();
			                                }
			                            });
			                        }
			                    }
			                });
						}
					}
				});
			},
			setLibera:function(){
				reprocessing.shi_codigo=0;
				reprocessing.id_det=0;
				reprocessing.id_lote=0;
				reprocessing.getLiberaPanel();
			},
			getLiberaPanel:function(){
				var bool=false;
				if(parseInt(reprocessing.shi_codigo)==0){ 
					bool= true;
				}
				if(parseInt(reprocessing.id_det)==0){
					bool= true;
				}
				if(parseInt(reprocessing.id_lote)==0){
					bool= true;
				}

				//Ext.getCmp(reprocessing.id+'-panel-paginas').setDisabled(bool);
				Ext.getCmp(reprocessing.id + '-grid-paginas').setDisabled(bool);
				Ext.getCmp(reprocessing.id+'-btn-reordenar').setDisabled(bool);
				Ext.getCmp(reprocessing.id+'-btn-asignar').setDisabled(bool);

				if(!bool){
					reprocessing.getReloadPage();
				}else{
					Ext.getCmp(reprocessing.id + '-grid-paginas').getStore().removeAll();
				}
			},
			renderTip:function(val, meta, rec, rowIndex, colIndex, store) {
			    // meta.tdCls = 'cell-icon'; // icon
			    meta.tdAttr = 'data-qtip="'+val+'"';
			    return val;
			},
			onMaxAllClick: function(){
		        Ext.suspendLayouts();
		        this.items.each(function(c){
		            c.setValue(100);
		        });
		        Ext.resumeLayouts(true);
		    },
		    
		    onSaveClick: function(){
		        Ext.Msg.alert({
		            title: 'Settings Saved',
		            msg: this.msgTpl.apply(this.getForm().getValues()),
		            icon: Ext.Msg.INFO,
		            buttons: Ext.Msg.OK
		        }); 
		    },
		    
		    onResetClick: function(){
		        this.getForm().reset();
		    },
			getImagen:function(param){
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/reprocessing/'+param}});
			},
			setreprocessing:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(reprocessing.id+'-form').el.mask('Cargando…', 'x-mask-loading');

						Ext.getCmp(reprocessing.id+'-form-info').submit({
		                    url: reprocessing.url + 'setRegisterCampana/',
		                    params:{
		                        vp_op: reprocessing.opcion,
		                        vp_shi_codigo:reprocessing.cod_cam,
		                        vp_shi_nombre:Ext.getCmp(reprocessing.id+'-txt-nombre').getValue(),
		                        vp_shi_descripcion:Ext.getCmp(reprocessing.id+'-txt-descripcion').getValue(),
		                        vp_fec_ingreso:Ext.getCmp(reprocessing.id+'-date-re').getRawValue(),
		                        vp_estado:Ext.getCmp(reprocessing.id+'-cmb-estado').getValue()
		                    },
		                    timeout: 300000,
		                    success: function( fp, o ){
		                    	//console.log(o);
		                        var res = o.result;
		                        Ext.getCmp(reprocessing.id+'-form').el.unmask();
		                        //console.log(res);
		                        if (parseInt(res.error) == 0){
		                            global.Msg({
		                                msg: res.data,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
		                                    reprocessing.getReloadGridreprocessing();
		                                    reprocessing.setNuevo();
		                                }
		                            });
		                        } else{
		                            global.Msg({
		                                msg: 'Ocurrio un error intentalo nuevamente.',
		                                icon: 0,
		                                buttons: 1,
		                                fn: function(btn){
		                                    reprocessing.getReloadGridreprocessing();
		                                    reprocessing.setNuevo();
		                                }
		                            });
		                        }
		                    }
		                });
		            }
                });
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(reprocessing.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(reprocessing.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(reprocessing.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridreprocessing:function(){
				//reprocessing.set_reprocessing_clear();
				//Ext.getCmp(reprocessing.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				var shi_codigo = Ext.getCmp(reprocessing.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(reprocessing.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(reprocessing.id+'-txt-lote').getValue();
				var name = Ext.getCmp(reprocessing.id+'-txt-reprocessing').getValue();
				var estado = 'A';//Ext.getCmp(reprocessing.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(reprocessing.id+'-txt-fecha-filtro').getRawValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(lote== null || lote==''){
		        	lote=0;
		        }
				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				Ext.getCmp(reprocessing.id + '-grid').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'RE',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(reprocessing.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				reprocessing.shi_codigo=0;
				reprocessing.getImagen('default.png');
				Ext.getCmp(reprocessing.id+'-txt-nombre').setValue('');
				Ext.getCmp(reprocessing.id+'-txt-descripcion').setValue('');
				Ext.getCmp(reprocessing.id+'-date-re').setValue('');
				Ext.getCmp(reprocessing.id+'-cmb-estado').setValue('');
				Ext.getCmp(reprocessing.id+'-txt-nombre').focus();
			},
			getAddMagicRefresh:function(url){
			    var symbol = '?';//url.indexOf('?') == -1 ? '?' : '&';
			    var magic = Math.random()*999999;
			    return url + symbol + 'magic=' + magic;
			},
			setImageFile: function(path,file){//(rec,recA){
				
				var panel = Ext.getCmp(reprocessing.id+'-panel_img');
                panel.removeAll();
                panel.add({
                    html: '<img id="imagen-scaneo" src="'+reprocessing.getAddMagicRefresh(path+file)+'" style="width:100%;" >'
                });

                var image = document.getElementById('imagen-scaneo');
                if(image!=null){
					var downloadingImage = new Image();
					downloadingImage.onload = function(){
					    image.src = this.src;
					    //reprocessing.getDropImg();
		                //reprocessing.load_file('-panel_texto','imagen-scaneo'); 
		                panel.doLayout();
					};
					downloadingImage.src = reprocessing.getAddMagicRefresh(path+file);
					panel.doLayout();
				}
		        /*var myMask = new Ext.LoadMask(Ext.getCmp('form-central-xim').el, {msg:"Por favor espere..."});
		        Ext.Ajax.request({
		            url: gestor_errores.url+'dig_qry_gestor_errores_detalle/',
		            params:{manifiesto:rec.get('man_id'),va_id_trama:rec.get('id_trama'),va_prov_codigo:recA.get('prov_codigo')},
		            success:function(response, options){
		                myMask.hide();
		                var file = Ext.decode(response.responseText);
		                gestor_errores.get_dat_form(file,recA);
		                var panel = Ext.getCmp(gestor_errores.id+'-panel_img');
		                panel.removeAll();
		                panel.add({
		                    html: '<img src="/imagenes/'+file.img+'.jpg" style="width:100%; height:100%;" >'
		                });
		                setTimeout("gestor_errores.delete_tiff('"+file.img+"')", 1200);
		                panel.doLayout();
		            }
		        });*/
		    },
		    delete_tiff: function(img){
		        /*Ext.Ajax.request({
		            url: gestor_errores.url+'delete_tiff/',
		            params:{img:img},
		            success:function(response, options){
		                var file = response.responseText;                
		            }
		        });*/
		    },
		    get_error_sel: function(rec_01){
		        /*var grid = Ext.getCmp(gestor_err.id+'-grid');
		        var rec = grid.getSelectionModel().getSelected();
		        gestor_errores.setImageFile(rec_01,rec);*/
		    },
		    setLimpiar:function(){
		        /*var panel = Ext.getCmp(gestor_errores.id+'-panel_img');
		        panel.removeAll();        
		        panel.doLayout();*/
		    }
		}
		Ext.onReady(reprocessing.init,reprocessing);
	}else{
		tab.setActiveTab(reprocessing.id+'-tab');
	}
</script>