<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('control-tab')){
		var control = {
			id:'control',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/control/',
			opcion:'I',
			id_pag:0,
			shi_codigo:0,
			fac_cliente:0,
			id_det:0,
			id_lote:0,
			trabajando:1,
			recordsToSend:[],
			cropper:{},
			cropperData:{},
			temporalFile:'none.jpg',
			selectImg:'',
			selectPath:'',
			id_pag:0,
			init:function(){
				Ext.Ajax.timeout = 180000;
            	Ext.QuickTips.init();
				Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
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
	                    url: control.url+'get_list_lotizer/'//,
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
	                 		Ext.getCmp(control.id + '-grid').doLayout();
	                 		//Ext.getCmp(control.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(control.id + '-grid').collapseAll();
		                    Ext.getCmp(control.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
		                    Ext.getCmp(control.id + '-grid').expandAll();
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
                    {name: 'cod_lote', type: 'string'},
                    {name: 'lote', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'usuario', type: 'string'},
                    {name: 'cantidad', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: control.url+'get_list/?vp_cod_lote=0',
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
                    {name: 'ocr', type: 'string'},
                    {name: 'estado', type: 'string'},
                    {name: 'include', type: 'string'},
	                {name: 'msg_error', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: control.url+'get_load_page/',
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
                    url: control.url+'get_list_shipper/',
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
                    url: control.url+'get_list_contratos/',
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
					id:control.id+'-form',
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
		                            title: 'Control de Lotes',
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
				                                            id:control.id+'-cbx-cliente',
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
				                                                	Ext.getCmp(control.id+'-cbx-contrato').setValue('');
				                                        			control.getContratos(records.get('shi_codigo'));
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
			                                                    id:control.id+'-cbx-contrato',
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
		                                                    id:control.id+'-txt-lote',
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
		                                                    id:control.id+'-txt-control',
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
			                                                id:control.id+'-txt-fecha-filtro',
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
		                               					            control.getReloadGridcontrol();
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
									layout:'fit',
									border:true,
									padding:'5px 5px 5px 5px',
									items:[
										{
					                        xtype: 'treepanel',
					                        //collapsible: true,
									        useArrows: true,
									        rootVisible: true,
									        multiSelect: true,
									        //root:'Task',
					                        id: control.id + '-grid',
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
				                                    renderer: control.renderTip,
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
				                                            id_menu: control.id_menu,
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
					                                            id_menu: control.id_menu,
					                                            icons:[
					                                                {id_serv: 2, img: '1315404769_gear_wheel.png', qtip: 'Cerrar Control.', js: "control.setCerrarEscaneado('X',"+shi_codigo+","+id_lote+")"},
					                                                {id_serv: 2, img: 'menu-16.png', qtip: 'Reprocesar.', js: "control.setCerrarEscaneado('R',"+shi_codigo+","+id_lote+")"}
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
					                                //control.getImagen('default.png');
					                                
					                            },
												beforeselect:function(obj, record, index, eOpts ){
													control.shi_codigo=record.get('shi_codigo');
													control.id_det=record.get('id_det');
													control.id_lote=record.get('id_lote');
													control.getReloadPage();
												}
					                        }
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
									region:'north',
									border:false,
									height:60,
									padding:'5px 20px 5px 20px',
									bodyStyle: 'background: transparent',
									layout: 'hbox',
									items:[
										{
						                    xtype: 'button',
						                    id:control.id+'-txt-btn-play',
						                    icon: '/images/icon/if_Play_984752.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Inicar',
						                    //iconAlign: 'top'
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
                       					            control.setCreateTemporalFile();
					                            }
					                        }
						                },
						                {
						                    xtype: 'button',
						                    id:control.id+'-txt-btn-save',
						                    disabled:true,
						                    icon: '/images/icon/if_24_111010.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Guardar',
						                    //iconAlign: 'top'
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
                       					            control.setSaveChangeFile();
					                            }
					                        }
						                },
										/*{
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
						                },*/
						                {
						                    xtype: 'button',
						                    id:control.id+'-txt-btn-rotar',
						                    disabled:true,
						                    icon: '/images/icon/if_icons_update_1564533.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Rotar',
						                    //iconAlign: 'top'
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
                       					            control.setRotateImage();
					                            }
					                        }
						                },
						                {
						                    xtype: 'button',
						                    id:control.id+'-txt-btn-cortar',
						                    disabled:true,
						                    icon: '/images/icon/if_122_111086.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Cortar',
						                    //iconAlign: 'top'
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
                       					            control.getDropImg();
					                            }
					                        }
						                },
						                {
						                    xtype: 'button',
						                    id:control.id+'-txt-btn-confirn',
						                    disabled:true,
						                    icon: '/images/icon/if_Ok_984756.png',
						                    flex:1,
						                    scale: 'large',
						                    //glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    //text: '[Delete]',
						                    text: 'Confirmar Corte',
						                    //iconAlign: 'top'
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
                       					            control.setDrop();
					                            }
					                        }
						                },
						                {
						                    xtype: 'button',
						                    id:control.id+'-txt-btn-cancelar',
						                    disabled:true,
						                    icon: '/images/icon/if_log_out_678146.png',
						                    flex:1,
						                    scale: 'large',
						                    //glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    //text: '[Delete]',
						                    text: 'Cancelar',
						                    //iconAlign: 'top'
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
					                            	//control.setCancelarFile();
					                            	control.setRotateBTN(true);
					                            }
					                        }
						                },
						                {
						                    xtype: 'button',
						                    id:control.id+'-txt-btn-deshacer',
						                    disabled:true,
						                    icon: '/images/icon/if_90_111056.png',
						                    flex:1,
						                    scale: 'large',
						                    //glyph: 72,
						                    margin:'5px 5px 5px 5px',
						                    //text: '[Delete]',
						                    text: 'Deshacer',
						                    //iconAlign: 'top'
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
                       					            control.setCreateTemporalFile();
					                            }
					                        }
						                }
									]
								},
								{
									region:'center',
									id: control.id+'-panel_img',
									border:true,
									autoScroll:true,
									padding:'5px 5px 5px 5px',
									items:[
										{
											html:'<img id="imagen-control-xim" src="/plantillas/Document-Scanning-Indexing-Services-min.jpg" width="100%" height="100%"/>'
										}
									] 
								},
								{
									region:'south',
									title:'Texto Página - OCR',
									height:100,
									border:false,
									layout:'fit',
									items:[
										{
	                                        xtype: 'textarea',	
	                                        //fieldLabel: 'Texto',
	                                        id:control.id+'-txt-texto-pagina',
	                                        labelWidth:0,
	                                        //maskRe: /[0-9]/,
	                                        readOnly:true,
	                                        labelAlign:'right',
	                                        width:'100%',
	                                        anchor:'100%'
	                                    }
									]
								}
							]
						},
						{
							region:'west',
							border:true,
							width:300,
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'north',
									hidden:true,
									border:true,
									height:60,
									padding:'5px 5px 5px 5px',
									bodyStyle: 'background: transparent',
									layout: 'hbox',
									items:[
										{
						                    xtype: 'button',
						                    icon: '/images/icon/if_BT_file_text_plus_905568.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Pág.(0)',
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_BT_file_text_minus_905569.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Error.(0)',
						                    //iconAlign: 'top'
						                },
						                {
						                    xtype: 'button',
						                    icon: '/images/icon/if_BT_binder_905575.png',
						                    flex:1,
						                    //glyph: 72,
						                    scale: 'large',
						                    margin:'5px 5px 5px 5px',
						                    //height:50
						                    text: 'Total.(0)',
						                    //iconAlign: 'top'
						                },
									]
								},
								{
									region:'center',
									layout:'border',
									border:true,
									padding:'5px 5px 5px 5px',
									bbar:[
										{
					                        xtype:'button',
					                        id:control.id+'-btn-ocr',
					                        //disabled:true,
					                        scale: 'large',
					                        //iconAlign: 'top',
					                        //disabled:true,
					                        width:'99%',
                                            anchor:'99%',
					                        text: 'Procesar todo con OCR',
					                        icon: '/images/icon/if_SVG_LINE_TECHNOLOGY-01_2897334.png',
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
					                            	//scanning.work=!scanning.work;
					                            	control.setProcessingOCR();
					                            }
					                        }
					                    }
									],
									items:[
										{
											region:'center',
											border:false,
											layout:'fit',
											tbar:[
												{
									                 xtype : 'progressbar',
									                 id:control.id + '-progressbar',
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
													       	if(control.trabajando==2){
													       		punto='..';
													       	}else if(control.trabajando==3){
													       		punto='...';
													       		control.trabajando=0;
													       	}
													       	control.trabajando+=1;
													       	obj.setTextTpl('Trabajando '+punto); 
													    }
									                 }
									             }
											],
											items:[
												{
							                        xtype: 'grid',
							                        id: control.id + '-grid-paginas',
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
							                                {
							                                    text: 'Descripción',
							                                    dataIndex: 'file',
							                                    flex: 1
							                                },
							                                {
							                                    text: 'OCR',
							                                    dataIndex: 'ocr',
							                                    width: 50,
							                                    align: 'center',
							                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
							                                        //console.log(record);
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        var estado = (record.get('ocr')=='N')?'check-circle-black-16.png':'check-circle-green-16.png';
							                                        var qtip = (record.get('ocr')=='Y')?'Con OCR':'Sin OCR';
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: control.id_menu,
							                                            icons:[
							                                                {id_serv: 2, img: estado, qtip: qtip, js: ""}
							                                            ]
							                                        });
							                                    }
							                                },
							                                {
							                                    text: 'DLT',
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
							                                            id_menu: control.id_menu,
							                                            icons:[
							                                                {id_serv: 2, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "control.setRemoveFile("+rowIndex+")"},
							                                                {id_serv: 2, img: ico, qtip: msn, js: "control.setMSGREPRO("+rowIndex+")"}
							                                            ]
							                                        });
							                                    }
							                                }
							                            ],
							                            defaults:{
							                                menuDisabled: true
							                            }
							                        },
							                        viewConfig: {
							                            stripeRows: true,
							                            enableTextSelection: false,
							                            markDirty: false
							                        },
							                        trackMouseOver: false,
							                        listeners:{
							                            afterrender: function(obj){
							                                
							                            },
							                            beforeselect:function(obj, record, index, eOpts ){
							                            	console.log(record);
							                            	//document.getElementById('imagen-control').innerHTML='<img id="imagen-control-xim" src="'+record.get('path')+record.get('file')+'" width="100%" height="100%"/>'
							                            	control.selectImg=record.get('file'),
							                            	control.selectPath=record.get('path');
															control.id_pag=record.get('id_pag');
															control.id_det=record.get('id_det');
															control.id_lote=record.get('id_lote');
															control.setResetBtn(true);
							                            	control.setImageFile(record.get('path'),record.get('file'));
							                            }
							                        }
							                    }
											]
										},
										{
											region:'south',
											id:control.id+'-panel-imagen-trazo',
											hidden:true,
											border:false,
											height:300,
											bbar:[
												{
			                                        xtype: 'textarea',	
			                                        //fieldLabel: 'Texto',
			                                        id:control.id+'-txt-texto-trazo',
			                                        labelWidth:0,
			                                        //maskRe: /[0-9]/,
			                                        readOnly:true,
			                                        labelAlign:'right',
			                                        width:'100%',
			                                        anchor:'100%',
			                                        height:60
			                                    }
											],
											html: '<img id="imagen-trazo-control" src="" style="width:100%;overflow: scroll;" />'
										}
									]
								}
							]
						}
					]
				});
				tab.add({
					id:control.id+'-tab',
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
	                        global.state_item_menu(control.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,control.id_menu);
	                        //control.getImg_tiff('escaneado');
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(control.id_menu, false);
	                    }
					}

				}).show();
			},
			setMSGREPRO:function(index){
				var rec = Ext.getCmp(control.id + '-grid-paginas').getStore().getAt(index);
				control.id_pag=rec.data.id_pag;
                control.id_det=rec.data.id_det;
                control.id_lote=rec.data.id_lote; 
                var IU = (parseInt(rec.data.id_pag_error) == 0)?'I':'U';

                var msg='Página no legible.';
                if(IU=='U'){
                	msg= rec.data.msg_error;
                }


                Ext.create('Ext.window.Window',{
	                id:control.id+'-win-form',
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
                            id:control.id+'-txt-texto-reproceso',
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
	                        text: 'Grabar',
	                        icon: '/images/icon/save.png',
	                        listeners:{
	                            beforerender: function(obj, opts){
								},
	                            click: function(obj, e){
	                            	control.setSaveReproFile(IU);
	                            }
	                        }
	                    },
	                    '-',
	                    {
	                        xtype:'button',
	                        disabled:(IU=='I')?true:false,
	                        text: 'Eliminar',
	                        icon: '/images/icon/recicle_nov.ico',
	                        listeners:{
	                            beforerender: function(obj, opts){
								},
	                            click: function(obj, e){
	                            	control.setSaveReproFile('D');
	                            }
	                        }
	                    },
	                    {
	                        xtype:'button',
	                        text: 'Salir',
	                        icon: '/images/icon/get_back.png',
	                        listeners:{
	                            beforerender: function(obj, opts){
	                            },
	                            click: function(obj, e){
	                                Ext.getCmp(control.id+'-win-form').close();
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
			setSaveReproFile:function(op){
		    	var msn=Ext.getCmp(control.id+'-txt-texto-reproceso').getValue();
				if(parseInt(control.id_det)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(control.id_lote)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(control.id_pag)==0){
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
                    		Ext.getCmp(control.id+'-win-form').el.mask('Actualizando Páginas…', 'x-mask-loading');
	                        control.getLoader(true);
			                Ext.Ajax.request({
			                    url:control.url+'setSaveReproFile/',
			                    params:{
			                    	vp_op:op,
			                    	vp_id_pag:control.id_pag,
			                    	vp_id_det:control.id_det,
			                    	vp_id_lote:control.id_lote,
			                    	vp_msn:msn
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                        Ext.getCmp(control.id+'-win-form').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        control.getLoader(false);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	control.getReloadPage();
			                                	Ext.getCmp(control.id+'-win-form').close();
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
			setSaveChangeFile:function(){
				global.Msg({
                    msg: '¿Está seguro de guardar la imagen editada?',
                    icon: 2,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
							Ext.getCmp(control.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
							control.setHabilitarFunciones(true);
							var path = control.selectPath;
							var img = control.selectImg;
							Ext.Ajax.request({
			                    url: control.url + 'setSaveChangeFile/',
			                    params:{
			                    	path:path,
			                		img:img,
			                		temporalFile:control.temporalFile
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                    	//Ext.getCmp(control.id+'-panel-trazos-form').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        
			                        control.getLoader(false);
			                        if (res.error == 'OK'){
			                        	//console.log(res.data);
			                        	control.temporalFile='none.jpg';
			                        	//control.setHabilitarFunciones(true);
			                        	//control.setRotateBTN(true);
			                        	control.setResetBtn(true);
			                        	//document.getElementById('imagen-control').innerHTML='<img id="imagen-control-xim" src="'+path+img+'" width="100%" height="100%"/>'
			                        	control.setImageFile(path,img);
			                        	Ext.getCmp(control.id+'-tab').el.unmask();

			                        }else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    //control.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
			                                    Ext.getCmp(control.id+'-form').el.unmask();
			                                    control.setHabilitarFunciones(true);
			                                    Ext.getCmp(control.id+'-tab').el.unmask();
			                                }
			                            });
			                        }
			                    }
			                });
			    		}
		            }
                });
			},
			setSaveDrop:function(op,json){
				var data = control.cropper.getCropBoxData();

				var container=control.cropper.getContainerData();
				var wa = json.width /  parseFloat(container.width);
				var wb = json.height / parseFloat(container.height);
				
				var top= parseFloat(data.top) * wb;
	            var left= parseFloat(data.left)* wa;
	            var width= parseFloat(data.width)* wa;
	            var height= parseFloat(data.height)* wb;
             	var path = '/filedit/';
				var img = control.temporalFile;

             	global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 2,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(control.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
	                        Ext.Ajax.request({
			                    url: control.url + 'set_resize_file/',
			                    params:{
			                    	vp_op:'R',
							        vp_y:top,
							        vp_x:left,
							        vp_w:width,
							        vp_h:height,
							        vp_path:path,
							        vp_img:img,
							        vp_width:json.width,
							        vp_height:json.height
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                    	control.setRotateBTN(true);
			                    	//Ext.getCmp(control.id+'-tab').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        if (res.error == 'OK'){
			                        	control.temporalFile=res.file; 
			                            control.setImageFile(path,control.temporalFile);
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    //OCR.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
			                                    Ext.getCmp(control.id+'-tab').el.unmask();
			                                }
			                            });
			                        }
			                    }
			                });
						}
		            }
                });
			},
			setDrop:function(){
				var path = '/filedit/';
				var img = control.temporalFile;
				var image = path+img;
				control.getSizeImg(image,'S',control.setSaveDrop);
			},
			getSizeImg:function(imgSrc,op,callback){
				var newImg = new Image();
			    newImg.onload = function () {
			    	var imgWidth = newImg.width || newImg.naturalWidth;
					var imgHeight = newImg.height || newImg.naturalHeight;
					console.log(imgWidth)
					console.log(imgHeight)
			        if (callback != undefined)callback(op,{width: imgWidth, height: imgHeight})
			    }
			    newImg.src = imgSrc;
			},
			getDropImg:function(){
				control.setRotateBTN(false);
				var image = document.getElementById('imagen-control');
		      	try{
			      control.cropper = new Cropper(image, {
			      	//dragMode: 'move',
			      	movable: false,
			        zoomable: false,
			        rotatable: false,
			        scalable: false,
			        cropBoxMovable: true,
			        cropBoxResizable: true,
			        ready: function (event) {
			        },
			        crop: function (event) {
			          //console.log(OCR.cropper.getCropBoxData());
			          control.cropperData=control.cropper.getCropBoxData();
			        },

			        zoom: function (event) {
			          // Keep the image in its natural size
			          if (event.detail.oldRatio === 1) {
			            event.preventDefault();
			          }
			        },
			      });
				}catch(err) {
				    console.log(err.message);
				}
			},
			setCreateTemporalFile:function(){
				if(parseInt(control.id_pag)==0){ 
					global.Msg({msg:"Seleccione una página por favor.",icon:2,fn:function(){}});
					return false;
				}
				Ext.getCmp(control.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
				control.setHabilitarFunciones(true);
				var path = control.selectPath;
				var img = control.selectImg;
				Ext.Ajax.request({
                    url: control.url + 'set_create_temporal_file/',
                    params:{
                    	path:path,
                		img:img,
                		temporalFile:control.temporalFile
                    },
                    timeout: 300000,
                    success: function(response, options){
                    	//Ext.getCmp(control.id+'-panel-trazos-form').el.unmask();
                        var res = Ext.JSON.decode(response.responseText);
                        //Ext.getCmp(control.id+'-tab').el.unmask();
                        control.getLoader(false);
                        if (res.error == 'OK'){
                        	//console.log(res.data);
                        	control.temporalFile=res.file;
                        	control.setHabilitarFunciones(false);
                        	control.setRotateBTN(true);
                        	//document.getElementById('imagen-control').innerHTML='<img id="imagen-control-xim" src="'+path+img+'" width="100%" height="100%"/>'
                        	control.setImageFile('/filedit/',control.temporalFile);

                        }else{
                            global.Msg({
                                msg: res.msn,
                                icon: 0,
                                buttons: 1,
                                fn: function(btn){
                                    //control.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
                                    //Ext.getCmp(control.id+'-form').el.unmask();
                                    control.setHabilitarFunciones(true);
                                    Ext.getCmp(control.id+'-tab').el.unmask();
                                }
                            });
                        }
                    }
                });
			},
			setRotateImage:function(){
				Ext.getCmp(control.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
				Ext.Ajax.request({
                    url: control.url + 'setRotateImage/',
                    params:{
                		temporalFile:control.temporalFile
                    },
                    timeout: 300000,
                    success: function(response, options){
                    	//Ext.getCmp(control.id+'-panel-trazos-form').el.unmask();
                        var res = Ext.JSON.decode(response.responseText);
                        
                        control.getLoader(false);
                        if (res.error == 'OK'){
                        	//console.log(res.data);
                        	control.temporalFile=res.file;
                        	//document.getElementById('imagen-control').innerHTML='<img id="imagen-control-xim" src="'+path+img+'" width="100%" height="100%"/>'
                        	control.setImageFile('/filedit/',control.temporalFile);

                        }else{
                            global.Msg({
                                msg: res.msn,
                                icon: 0,
                                buttons: 1,
                                fn: function(btn){
                                    //control.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
                                    //control.setHabilitarFunciones(true);
                                    Ext.getCmp(control.id+'-tab').el.unmask();
                                }
                            });
                        }
                    }
                });
			},
			setCancelarFile:function(){
				Ext.getCmp(control.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
				control.setHabilitarFunciones(true);
				var path = control.selectPath;
				var img = control.selectImg;
				Ext.Ajax.request({
                    url: control.url + 'set_delete_temporal_file/',
                    params:{
                    	path:path,
                		img:img,
                		temporalFile:control.temporalFile
                    },
                    timeout: 300000,
                    success: function(response, options){
                    	//Ext.getCmp(control.id+'-panel-trazos-form').el.unmask();
                        var res = Ext.JSON.decode(response.responseText);
                        
                        control.getLoader(false);
                        if (res.error == 'OK'){
                        	//console.log(res.data);
                        	control.temporalFile='none.jpg';
                        	control.setHabilitarFunciones(true);
                        	//document.getElementById('imagen-control').innerHTML='<img id="imagen-control-xim" src="'+path+img+'" width="100%" height="100%"/>'
                        	control.setImageFile(path,img);
                        	Ext.getCmp(control.id+'-tab').el.unmask();

                        }else{
                            global.Msg({
                                msg: res.msn,
                                icon: 0,
                                buttons: 1,
                                fn: function(btn){
                                    //control.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
                                    Ext.getCmp(control.id+'-form').el.unmask();
                                    control.setHabilitarFunciones(true);
                                    Ext.getCmp(control.id+'-tab').el.unmask();
                                }
                            });
                        }
                    }
                });
			},
			getAddMagicRefresh:function(url){
			    var symbol = '?';//url.indexOf('?') == -1 ? '?' : '&';
			    var magic = Math.random()*999999;
			    return url + symbol + 'magic=' + magic;
			},
			setImageFile: function(path,file){//(rec,recA){
				var panel = Ext.getCmp(control.id+'-panel_img');
                panel.removeAll();
                panel.add({
                    html: '<img id="imagen-control" src="'+control.getAddMagicRefresh(path+file)+'" style="width:100%;" >'
                });

                var image = document.getElementById('imagen-control');
                if(image!=null){
					var downloadingImage = new Image();
					downloadingImage.onload = function(){
					    image.src = this.src;
		                panel.doLayout();
					};
					downloadingImage.src = control.getAddMagicRefresh(path+file);
					panel.doLayout();
					Ext.getCmp(control.id+'-tab').el.unmask();
				}
		    },
		    setResetBtn:function(bool){
				Ext.getCmp(control.id+'-txt-btn-play').setDisabled(!bool);
				Ext.getCmp(control.id+'-txt-btn-save').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-rotar').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-cortar').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-confirn').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-cancelar').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-deshacer').setDisabled(bool);
			},

			setHabilitarFunciones:function(bool){
				Ext.getCmp(control.id+'-txt-btn-play').setDisabled(!bool);
				Ext.getCmp(control.id+'-txt-btn-save').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-rotar').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-cortar').setDisabled(bool);
				//Ext.getCmp(control.id+'-txt-btn-confirn').setDisabled(bool);
				//Ext.getCmp(control.id+'-txt-btn-cancelar').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-deshacer').setDisabled(bool);
			},
			setRotateBTN:function(bool){
				Ext.getCmp(control.id+'-txt-btn-cortar').setDisabled(!bool);
				Ext.getCmp(control.id+'-txt-btn-confirn').setDisabled(bool);
				Ext.getCmp(control.id+'-txt-btn-cancelar').setDisabled(bool);
				if(bool){
					control.setImageFile('/filedit/',control.temporalFile);
				}
			},
			getLoader:function(bool){
				if(bool){
					Ext.getCmp(control.id + '-progressbar').show();
					Ext.getCmp(control.id + '-progressbar').wait({
			            interval: 200,
			            //duration: 5000,
			            increment: 15,
			            fn:function() {
			                //btn3.dom.disabled = false;
			                //Ext.fly('p3text').update('Done');

			            }
			        });
				}else{
					Ext.getCmp(control.id + '-progressbar').setTextTpl('Finalizado'); 
					Ext.getCmp(control.id + '-progressbar').hide();
				}
			},
			setProcessingOCR:function(){
				global.Msg({
                    msg: '¿Está seguro de procesar todas las Páginas con OCR?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(control.id+'-tab').el.mask('Guardando Texto de Trazos - OCR', 'x-mask-loading');
							control.getLoader(true);
							try{
						    	//Procesar OCR
						    	Ext.Ajax.request({
				                    url: control.url + 'set_list_page_trazos/',
				                    params:{
				                    	vp_id_pag:0,
				                		vp_shi_codigo:control.shi_codigo,
				                    	vp_id_det:control.id_det,
				                    	vp_id_lote:control.id_lote,
				                    	vp_ocr:'N'
				                    },
				                    timeout: 300000,
				                    success: function(response, options){
				                    	//Ext.getCmp(control.id+'-panel-trazos-form').el.unmask();
				                        var res = Ext.JSON.decode(response.responseText);
				                        Ext.getCmp(control.id+'-tab').el.unmask();
				                        control.getLoader(false);
				                        if (res.error == 'OK'){
				                        	//console.log(res.data);
				                        	global.Msg({
				                                msg: res.msn,
				                                icon: 1,
				                                buttons: 1,
				                                fn: function(btn){
				                        			control.getReloadPage();
				                                }
				                            });
				                        	
				                        }else{
				                            global.Msg({
				                                msg: res.msn,
				                                icon: 0,
				                                buttons: 1,
				                                fn: function(btn){
				                                    //control.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
				                                    Ext.getCmp(control.id+'-form').el.unmask();
				                                }
				                            });
				                        }
				                    }
				                });
							}catch(err){
								global.Msg({
	                                msg: err.message,
	                                icon: 0,
	                                buttons: 1,
	                                fn: function(btn){
	                                    Ext.getCmp(control.id+'-form').el.unmask();
										control.getLoader(false);
	                                }
	                            });
							}
						}
					}
				});
			},
			setProcessingOCR2:function(){
				global.Msg({
                    msg: '¿Está seguro de procesar todas las Páginas con OCR?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(control.id+'-tab').el.mask('Guardando Texto de Trazos - OCR', 'x-mask-loading');
							control.getLoader(true);
							try{
						    	//Procesar OCR
						    	Ext.Ajax.request({
				                    url: control.url + 'set_list_page_trazos/',
				                    params:{
				                    	vp_id_pag:0,
				                		vp_shi_codigo:control.shi_codigo,
				                    	vp_id_det:control.id_det,
				                    	vp_id_lote:control.id_lote,
				                    	vp_ocr:'N'
				                    },
				                    success: function(response, options){
				                    	Ext.getCmp(control.id+'-tab').el.unmask();
				                        var res = Ext.JSON.decode(response.responseText);
				                        if (res.error == 'OK'){
				                        	//console.log(res.data);
				                        	control.recordsToSend = [];
				                        	var countPage=Ext.getCmp(control.id + '-grid-paginas').getStore().getCount();
				                        	var countGlobal =0;

				                        	Ext.getCmp(control.id + '-grid-paginas').getStore().each(function(record, idx) {
											    if(record.get('ocr')=='N'){
											    	//console.log(record.get('path')+record.get('file'));
											    	//Ext.getCmp(control.id+'-form').el.unmask();
											    	var image = document.getElementById('imagen-control-xim'); 
													var downloadingImage = new Image();
													var data=res.data;
													var id_pag= record.get('id_pag');
													//var cod_trazo= record.get('cod_trazo');
													//var id_det =record.get('id_det');
													//var id_lote =record.get('id_lote');

													downloadingImage.onload = function(){
														image.src = this.src;
														try{
															OCRAD(image,{
																numeric: false
															},
															function(text){
																text = text.replace(/(\r\n\t|\n|\r\t)/gm,"");
																text = text.replace('"',"");
																text = text.replace("'","");
																text = text.replace('`',"");
																control.recordsToSend.push(Ext.apply({id_pag:id_pag,cod_trazo:0,id_det:control.id_det,id_lote:control.id_lote,text:text},id_pag));

																Ext.getCmp(control.id + '-grid-paginas').getSelectionModel().select(idx, true);
																//console.log(text);
																Ext.getCmp(control.id+'-txt-texto-pagina').setValue(text);
																var countPage=0;
																var countPageCurrent=0;
																for(var x=0;x<data.length;x++){
																	if(parseInt(id_pag) == parseInt(data[x].id_pag)){
																		countPage+=1;
																	}
																}
									                        	for(var i=0;i<data.length;i++){
									                        		if(parseInt(id_pag) == parseInt(data[i].id_pag)){
									                        			countPageCurrent+=1;
										                        		//console.log(data[i]);
										                        		//OCR.cod_trazo = parseInt(res.cod_trazo);
														                var image2 = document.getElementById('imagen-trazo-control');
																		var downloadingImage2 = new Image();
																		var n= (data[i].tipo=='S')?false:true;
																		var cod_trazo = data[i].cod_trazo;
																		var id_det = data[i].id_det;
																		var id_lote = data[i].id_lote;
																		downloadingImage2.onload = function(){
																		    image2.src = this.src;
																		    Ext.getCmp(control.id+'-panel-imagen-trazo').doLayout();
																		    //OCR.getSizeImg('/scanning/escaneado.jpg','S',{left:record.data.x,top:record.data.y,width:record.data.w,height:record.data.h},OCR.getResizeOrigin);
																		    //OCR.getTextoImage();
																		    try{
																				OCRAD(image2,{
																					numeric: n
																				},
																				function(text2){
																					text2 = text2.replace(/(\r\n\t|\n|\r\t)/gm,"");
																					text2 = text2.replace('"',"");
																					text2 = text2.replace('`',"");
																					text2 = text2.replace("'","");
																					//console.log(text2);
																					control.recordsToSend.push(Ext.apply({id_pag:id_pag,cod_trazo:cod_trazo,id_det:id_det,id_lote:id_lote,text:text2},id_pag));
																					Ext.getCmp(control.id+'-txt-texto-trazo').setValue(text2);
																					if(countPage==countPageCurrent){
																						//record.set('ocr', 'Y');
																					    //page = record.get('id_pag');
																					    //record.commit();
																					    countGlobal+=1;
																					    if(countPage==countGlobal){
																					    	console.log(control.recordsToSend);
																					    	var recordsToSend = Ext.encode(control.recordsToSend);
																							//console.log(recordsToSend);

																					    	Ext.Ajax.request({
																			                    url: control.url + 'set_ocr_pages/',
																			                    params:{
																			                    	vp_recordsToSend:recordsToSend
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
																				});
																			}catch(err) {
																			    console.log(err.message);
																			}
																		};
																		downloadingImage2.src = /tmp_trazos/ + data[i].id_pag+'-'+data[i].cod_trazo+'-trazo.'+data[i].extension;
																	}
									                        	};
															});
														}catch(err) {
														    console.log(err.message);
														}
							                        };
							                        downloadingImage.src = record.get('path')+record.get('file');
											    }
											});
				                        }else{
				                            global.Msg({
				                                msg: res.msn,
				                                icon: 0,
				                                buttons: 1,
				                                fn: function(btn){
				                                    //control.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
				                                    Ext.getCmp(control.id+'-form').el.unmask();
													control.getLoader(false);
				                                }
				                            });
				                        }
				                    }
				                });
							}catch(err){
								global.Msg({
	                                msg: err.message,
	                                icon: 0,
	                                buttons: 1,
	                                fn: function(btn){
	                                    Ext.getCmp(control.id+'-form').el.unmask();
										control.getLoader(false);
	                                }
	                            });
							}
						}
					}
				});
			},
			setCerrarEscaneado:function(vp_op,shi_codigo,id_lote){
				if(parseInt(shi_codigo)==0){ 
					global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(id_lote)==0){
					global.Msg({msg:"Seleccione un Lote.",icon:2,fn:function(){}});
					return false;
				}

				global.Msg({
                    msg: (vp_op=='X')?'¿Seguro de cerrar Lote?':'Seguro de Enviar a Reproceso?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(control.id+'-tab').el.mask('Cerrando Lote…', 'x-mask-loading');
	                        control.getLoader(true);
			                Ext.Ajax.request({
			                    url:control.url+'set_lotizer/',
			                    params:{
			                    	vp_op:vp_op,
			                    	vp_shi_codigo:shi_codigo,
			                    	vp_id_lote:id_lote
			                    },
			                    success: function(response, options){
			                        Ext.getCmp(control.id+'-tab').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        control.getLoader(false);
			                        //scanning.setLibera();
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	control.getReloadGridcontrol();
			                                	//control.getReloadPage();
			                                	control.id_pag=0;
			                                	control.setResetBtn(true);
			                                	Ext.getCmp(control.id + '-grid-paginas').getStore().removeAll();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                	//control.getReloadGridcontrol();
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
			getReloadPage:function(){
				control.id_pag=0;
				control.setResetBtn(true);
				Ext.getCmp(control.id + '-grid-paginas').getStore().removeAll();
				Ext.getCmp(control.id + '-grid-paginas').getStore().load({
                	params:{
                		vp_id_pag:0,
                		vp_shi_codigo:control.shi_codigo,
                    	vp_id_det:control.id_det,
                    	vp_id_lote:control.id_lote
	                },
	                callback:function(){
	                	//Ext.getCmp(scanning.id+'-form').el.unmask();
	                	//control.setChangeRow();
	                }
	            });
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
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/control/'+param}});
			},
			setcontrol:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(control.id+'-tab').el.mask('Cargando…', 'x-mask-loading');

						Ext.getCmp(control.id+'-form-info').submit({
		                    url: control.url + 'setRegisterCampana/',
		                    params:{
		                        vp_op: control.opcion,
		                        vp_shi_codigo:control.cod_cam,
		                        vp_shi_nombre:Ext.getCmp(control.id+'-txt-nombre').getValue(),
		                        vp_shi_descripcion:Ext.getCmp(control.id+'-txt-descripcion').getValue(),
		                        vp_fec_ingreso:Ext.getCmp(control.id+'-date-re').getRawValue(),
		                        vp_estado:Ext.getCmp(control.id+'-cmb-estado').getValue()
		                    },
		                    success: function( fp, o ){
		                    	//console.log(o);
		                        var res = o.result;
		                        Ext.getCmp(control.id+'-tab').el.unmask();
		                        //console.log(res);
		                        if (parseInt(res.error) == 0){
		                            global.Msg({
		                                msg: res.data,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
		                                    control.getReloadGridcontrol();
		                                    control.setNuevo();
		                                }
		                            });
		                        } else{
		                            global.Msg({
		                                msg: 'Ocurrio un error intentalo nuevamente.',
		                                icon: 0,
		                                buttons: 1,
		                                fn: function(btn){
		                                    control.getReloadGridcontrol();
		                                    control.setNuevo();
		                                }
		                            });
		                        }
		                    }
		                });
		            }
                });
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(control.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(control.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(control.id+'-form').el.unmask();
	                	control.id_pag=0;
	                	control.setResetBtn(true);
	                	//control.getReloadGridcontrol()
	                }
	            });
			},
			getReloadGridcontrol:function(){
				Ext.getCmp(control.id + '-grid-paginas').getStore().removeAll();
				//control.set_control_clear();
				//Ext.getCmp(control.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				var shi_codigo = Ext.getCmp(control.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(control.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(control.id+'-txt-lote').getValue();
				var name = Ext.getCmp(control.id+'-txt-control').getValue();
				var estado = 'A';//Ext.getCmp(control.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(control.id+'-txt-fecha-filtro').getRawValue();

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
		        control.id_pag=0;
		        control.setResetBtn(true);
				Ext.getCmp(control.id + '-grid').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'CO',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(control.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				control.shi_codigo=0;
				control.getImagen('default.png');
				Ext.getCmp(control.id+'-txt-nombre').setValue('');
				Ext.getCmp(control.id+'-txt-descripcion').setValue('');
				Ext.getCmp(control.id+'-date-re').setValue('');
				Ext.getCmp(control.id+'-cmb-estado').setValue('');
				Ext.getCmp(control.id+'-txt-nombre').focus();
			},
			getImg_tiff: function(file){//(rec,recA){
				
				var panel = Ext.getCmp(control.id+'-panel_img');
                panel.removeAll();
                panel.add({
                    html: '<img id="imagen-control-xim" src="/scanning/'+file+'.jpg" style="width:100%; height:"100%;" >'
                });
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
		        gestor_errores.getImg_tiff(rec_01,rec);*/
		    },
		    setLimpiar:function(){
		        /*var panel = Ext.getCmp(gestor_errores.id+'-panel_img');
		        panel.removeAll();        
		        panel.doLayout();*/
		    },
		    setRemoveFile:function(index){
		    	var rec = Ext.getCmp(control.id + '-grid-paginas').getStore().getAt(index);
				control.id_pag=rec.data.id_pag;

                control.id_det=rec.data.id_det; 
                control.id_lote=rec.data.id_lote; 

		    	control.shi_codigo = Ext.getCmp(control.id+'-cbx-cliente').getValue();
				control.fac_cliente = Ext.getCmp(control.id+'-cbx-contrato').getValue();

				if(parseInt(control.shi_codigo)==0){ 
					global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(control.id_det)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(control.id_lote)==0){
					global.Msg({msg:"No tiene ningun folder seleccionado.",icon:2,fn:function(){}});
					return false;
				}
				if(parseInt(control.id_pag)==0){
					global.Msg({msg:"Seleccione una página.",icon:2,fn:function(){}});
					return false;
				}

				
				global.Msg({
                    msg: '¿Seguro de eliminar página(s)?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(control.id+'-tab').el.mask('Elinando Páginas…', 'x-mask-loading');
	                        scanning.getLoader(true);
			                Ext.Ajax.request({
			                    url:control.url+'set_remove_file/',
			                    params:{
			                    	vp_op:'D',
			                    	vp_shi_codigo:control.shi_codigo,
			                    	vp_id_pag:control.id_pag,
			                    	vp_id_det:control.id_det,
			                    	vp_id_lote:control.id_lote
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                        Ext.getCmp(control.id+'-tab').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        control.getLoader(false);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	control.getReloadPage();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                	control.getReloadPage();
			                                }
			                            });
			                        }
			                    }
			                });
						}
					}
				});
			},
		    removeDiacritics:function(str) {

			  var defaultDiacriticsRemovalMap = [
			    {'base':'A', 'letters':/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g},
			    {'base':'AA','letters':/[\uA732]/g},
			    {'base':'AE','letters':/[\u00C6\u01FC\u01E2]/g},
			    {'base':'AO','letters':/[\uA734]/g},
			    {'base':'AU','letters':/[\uA736]/g},
			    {'base':'AV','letters':/[\uA738\uA73A]/g},
			    {'base':'AY','letters':/[\uA73C]/g},
			    {'base':'B', 'letters':/[\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181]/g},
			    {'base':'C', 'letters':/[\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E]/g},
			    {'base':'D', 'letters':/[\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779]/g},
			    {'base':'DZ','letters':/[\u01F1\u01C4]/g},
			    {'base':'Dz','letters':/[\u01F2\u01C5]/g},
			    {'base':'E', 'letters':/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g},
			    {'base':'F', 'letters':/[\u0046\u24BB\uFF26\u1E1E\u0191\uA77B]/g},
			    {'base':'G', 'letters':/[\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E]/g},
			    {'base':'H', 'letters':/[\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D]/g},
			    {'base':'I', 'letters':/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g},
			    {'base':'J', 'letters':/[\u004A\u24BF\uFF2A\u0134\u0248]/g},
			    {'base':'K', 'letters':/[\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2]/g},
			    {'base':'L', 'letters':/[\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780]/g},
			    {'base':'LJ','letters':/[\u01C7]/g},
			    {'base':'Lj','letters':/[\u01C8]/g},
			    {'base':'M', 'letters':/[\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C]/g},
			    {'base':'N', 'letters':/[\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4]/g},
			    {'base':'NJ','letters':/[\u01CA]/g},
			    {'base':'Nj','letters':/[\u01CB]/g},
			    {'base':'O', 'letters':/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g},
			    {'base':'OI','letters':/[\u01A2]/g},
			    {'base':'OO','letters':/[\uA74E]/g},
			    {'base':'OU','letters':/[\u0222]/g},
			    {'base':'P', 'letters':/[\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754]/g},
			    {'base':'Q', 'letters':/[\u0051\u24C6\uFF31\uA756\uA758\u024A]/g},
			    {'base':'R', 'letters':/[\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782]/g},
			    {'base':'S', 'letters':/[\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784]/g},
			    {'base':'T', 'letters':/[\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786]/g},
			    {'base':'TZ','letters':/[\uA728]/g},
			    {'base':'U', 'letters':/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g},
			    {'base':'V', 'letters':/[\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245]/g},
			    {'base':'VY','letters':/[\uA760]/g},
			    {'base':'W', 'letters':/[\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72]/g},
			    {'base':'X', 'letters':/[\u0058\u24CD\uFF38\u1E8A\u1E8C]/g},
			    {'base':'Y', 'letters':/[\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE]/g},
			    {'base':'Z', 'letters':/[\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762]/g},
			    {'base':'a', 'letters':/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g},
			    {'base':'aa','letters':/[\uA733]/g},
			    {'base':'ae','letters':/[\u00E6\u01FD\u01E3]/g},
			    {'base':'ao','letters':/[\uA735]/g},
			    {'base':'au','letters':/[\uA737]/g},
			    {'base':'av','letters':/[\uA739\uA73B]/g},
			    {'base':'ay','letters':/[\uA73D]/g},
			    {'base':'b', 'letters':/[\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253]/g},
			    {'base':'c', 'letters':/[\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184]/g},
			    {'base':'d', 'letters':/[\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A]/g},
			    {'base':'dz','letters':/[\u01F3\u01C6]/g},
			    {'base':'e', 'letters':/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g},
			    {'base':'f', 'letters':/[\u0066\u24D5\uFF46\u1E1F\u0192\uA77C]/g},
			    {'base':'g', 'letters':/[\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F]/g},
			    {'base':'h', 'letters':/[\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265]/g},
			    {'base':'hv','letters':/[\u0195]/g},
			    {'base':'i', 'letters':/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g},
			    {'base':'j', 'letters':/[\u006A\u24D9\uFF4A\u0135\u01F0\u0249]/g},
			    {'base':'k', 'letters':/[\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3]/g},
			    {'base':'l', 'letters':/[\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747]/g},
			    {'base':'lj','letters':/[\u01C9]/g},
			    {'base':'m', 'letters':/[\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F]/g},
			    {'base':'n', 'letters':/[\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5]/g},
			    {'base':'nj','letters':/[\u01CC]/g},
			    {'base':'o', 'letters':/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g},
			    {'base':'oi','letters':/[\u01A3]/g},
			    {'base':'ou','letters':/[\u0223]/g},
			    {'base':'oo','letters':/[\uA74F]/g},
			    {'base':'p','letters':/[\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755]/g},
			    {'base':'q','letters':/[\u0071\u24E0\uFF51\u024B\uA757\uA759]/g},
			    {'base':'r','letters':/[\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783]/g},
			    {'base':'s','letters':/[\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B]/g},
			    {'base':'t','letters':/[\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787]/g},
			    {'base':'tz','letters':/[\uA729]/g},
			    {'base':'u','letters':/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g},
			    {'base':'v','letters':/[\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C]/g},
			    {'base':'vy','letters':/[\uA761]/g},
			    {'base':'w','letters':/[\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73]/g},
			    {'base':'x','letters':/[\u0078\u24E7\uFF58\u1E8B\u1E8D]/g},
			    {'base':'y','letters':/[\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF]/g},
			    {'base':'z','letters':/[\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763]/g}
			  ];

			  for(var i=0; i<defaultDiacriticsRemovalMap.length; i++) {
			    str = str.replace(defaultDiacriticsRemovalMap[i].letters, defaultDiacriticsRemovalMap[i].base);
			  }

			  return str;

			}
		}
		Ext.onReady(control.init,control);
	}else{
		tab.setActiveTab(control.id+'-tab');
	}
</script>