<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('client-tab')){
		var client = {
			id:'client',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/client/',
			opcion:'I',
			id_lote:0,
			shi_codigo:0,
			fac_cliente:0,
			init:function(){
				Ext.tip.QuickTipManager.init();
				//Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'shi_nombre', type: 'string'},
	                    {name: 'fec_ingreso', type: 'string'},
	                    {name: 'shi_estado', type: 'string'},
	                    {name: 'id_user', type: 'string'},
	                    {name: 'fecact', type: 'string'},
	                    {name: 'cod_contrato', type: 'string'},
	                    {name: 'pro_descri', type: 'string'}
				    ]
				});
				var storeTree2 = new Ext.data.TreeStore({
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: client.url+'get_list_clientcontratos/'

	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {

					    },
	                    load: function(obj, records, successful, opts){
	                 		Ext.getCmp(client.id + '-gridTree').doLayout();
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(client.id + '-gridTree').collapseAll();
		                    Ext.getCmp(client.id + '-gridTree').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
	                    }
	                }
	            });

				var storeTree = new Ext.data.TreeStore({
	                fields: [
	                	{name: 'shi_codigo', type: 'string'},
	                    {name: 'shi_nombre', type: 'string'},
	                    {name: 'fec_ingreso', type: 'string'},
	                    {name: 'shi_estado', type: 'string'},
						{name: 'id_user', type: 'string'},	                    
	                    {name: 'fecact', type: 'string'}
	                ],
				    autoLoad:false,
	                proxy: {	
	                    type: 'ajax',
	                    url: client.url+'get_list_client/',
	                    reader:{
	                        type: 'json',
	                        rootProperty: 'data'
	                    }
	                },
	                folderSort: true
	            });



				var store = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'id_lote', type: 'string'},
                    {name: 'tipdoc', type: 'string'},
                    {name: 'nombre', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'tot_folder', type: 'string'},                    
                    {name: 'id_user', type: 'string'},                    
                    {name: 'estado', type: 'string'}
                ],
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: client.url+'get_list_lotizer/',
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
                    url: client.url+'get_list_shipper/',
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
                    url: client.url+'get_list_contratos/',
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
			var myData = [
    				['1','Activo'],
				    ['0','Inactivo']
			];
			var store_estado = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myData,
		        fields: ['code', 'name']
		    });

		    var myDataLote = [
				    ['1','Activo'],
				    ['0','Inactivo']
			];
			var store_estado_lote = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myDataLote,
		        fields: ['code', 'name']
		    });

				var panel = Ext.create('Ext.form.Panel',{
					id:client.id+'-form',
					bodyStyle: 'background: transparent',
					border:false,
					layout:'border',
					defaults:{
						border:false
					},
					tbar:[],
					items:[
						
						
					]
				});
				tab.add({
					id:client.id+'-tab',
					border:false,
					autoScroll:true,
					closable:true,
					layout:'border',
					items:[
						{
                            region:'north',
                            layout:'border',
                            border:false,
                            height:150,
                            items:[
								/*{
		                            region:'west',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'CL',
		                            title: 'Clientes y Contratos',
		                            legend: 'Seleccione Clientes Registrados',
		                            width:600,
		                            //height:90,
		                            items:[
		                                {
		                                    xtype:'panel',
		                                    border:false,
		                                    bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',
		                                    items: [
		                                    	{
			                                   		width: 250,border:false,
			                                    	padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Cliente',
			                                                    id:lotizer.id+'-cbx-cliente',
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
			                                                        	Ext.getCmp(lotizer.id+'-cbx-contrato').setValue('');
			                                                			lotizer.getContratos(records.get('shi_codigo'));
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
			                                    {
			                                   		width: 270,border:false,
			                                    	padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Contrato',
			                                                    id:lotizer.id+'-cbx-contrato',
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
			                                    }
		                                    ]
		                                }
		                            ]
		                        },*/
		                        {
		                            region:'center',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'CL',
		                            title: 'Listado de Clientes',
		                            legend: 'Búsqueda de Clientes registrados',
		                            width:1000,
		                            height:40,
		                            items:[
		                                {
		                                    xtype:'panel',
		                                    border:false,
		                                    bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',
		                                    height: 60,





		                                    items: [
		                                        {

		                                            width:300,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Cliente',
		                                                    id:client.id+'-txt-cliente',
		                                                    labelWidth:55,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                },
		                                            ]
		                                        },

		                                        {
			                                        width: 160,border:false,
			                                        padding:'0px 2px 0px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                        items:[
			                                            {
			                                                xtype:'datefield',
			                                                id:client.id+'-txt-fecha-filtro',
			                                                fieldLabel:'Fecha',
			                                                labelWidth:60,
			                                                labelAlign:'right',
			                                                value:new Date(' '),
			                                                format: 'Ymd',
			                                                //readOnly:true,
			                                                width: '100%',
			                                                anchor:'100%'
			                                            }
			                                        ]
			                                    },
		                                        {
			                                   		width: 150,border:false,
			                                    	padding:'0px 2px 0px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Estado',
			                                                    id:client.id+'-txt-estado-filter',
			                                                    store: store_estado_lote,
			                                                    queryMode: 'local',
			                                                    triggerAction: 'all',
			                                                    valueField: 'code',	
			                                                    displayField: 'name',
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
			                                                            Ext.getCmp(client.id+'-txt-estado-filter').setValue(' ');
			                                                        },
			                                                        select:function(obj, records, eOpts){
			                                                
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
		                                        {
		                                            width: 180,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
									                        xtype:'button',
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
									                            	var name = Ext.getCmp(client.id+'-txt-cliente').getValue();
									                            	var fecha = Ext.getCmp(client.id+'-txt-fecha-filtro').getValue();
									                            	

									                            	

									                            	if(fecha == '0NaNNaNNaN' || fecha == '' ) 
									                            
									                            	{
									                            				fecha = '';
									                            	} 
									                          


									                            	var estado = Ext.getCmp(client.id+'-txt-estado-filter').getValue();	


		                               					            client.getReloadGridlotizer(name,fecha,estado);
									                            }
									                        }
									                    },
									                    {
															id: client.id + '-cancelar',
															//margin:'10px 2px 0px 0px',  
															//bodyStyle: 'background: transparent',
									                        xtype:'button',
									                        width:80,
									                        text: 'Limpiar',
									                        icon: '/images/icon/broom.png',
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
																	client.set_lotizer_clear();
									                            }
									                        }
									                    },

									                ]    			


		                                            
		                                        }
		                                    ]
   			

		                                }
		                            ]/*,

								                	bbar:[       
								                    '->',
								                    '-',

									                    {
															id: client.id + '-nuevo',
															//margin:'10px 2px 0px 0px',  
															//bodyStyle: 'background: transparent',
									                        xtype:'button',
									                        //width:80,
									                        text: 'Nuevo',
									                        icon: '/images/icon/add_green_button.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                                /*global.permisos({
									                                    id: 15,
									                                    id_btn: obj.getId(), 
									                                    id_menu: gestion_devolucion.id_menu,
									                                    fn: ['panel_asignar_gestion.limpiar']
									                                });
									                            },
									                            click: function(obj, e){
																	client.getFormMant('I','','1',0);
									                            }
									                        }
									                    }
									                ]*/



		                        }
		                    ],
								                	bbar:[  
								                    '-',								                	     
									                    {
															id: client.id + '-nuevo',
															//margin:'10px 2px 0px 0px',  
															//bodyStyle: 'background: transparent',
									                        xtype:'button',
									                        width:150,
									                        //height: 30,
									                        text: 'Nuevo Cliente',
									                        icon: '/images/icon/add_green_button.png',
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
																	client.getFormMant('I','','1',0);
									                            }
									                        }
									                    },
								                    '-'								                	     									                    

									                ]


		                },
						{
							region:'center',
							layout:'border',
							items:[
								{
									region:'center',
									//width:'100%',
									layout:'border',
									items:[
										/*{
											region:'north',
											border:false,
											height:70,
											items:[
												{
			                                        xtype: 'fieldset',
			                                        margin: '5 5 5 10',
			                                        title:'<b>Mantenimiento Clientes</b>',
			                                        border:true,
			                                        bodyStyle: 'background: transparent',
			                                        padding:'2px 5px 1px 5px',
			                                        layout:'column',
			                                        items: [
			                                            {
			                                                columnWidth: .3,border:false,
			                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
			                                                items:[
			                                                    {
			                                                        xtype: 'textfield',
			                                                        fieldLabel: 'Cliente',
			                                                        id:client.id+'-txt-nombre',
			                                                        labelWidth:60,
			                                                        //readOnly:true,
			                                                        labelAlign:'right',
			                                                        width:'100%',
			                                                        anchor:'100%'
			                                                    }
			                                                ]
			                                            },
			                                            {
			                                                columnWidth: .4,border:false,hidden:true,
			                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
			                                                items:[
			                                                    {
			                                                        xtype: 'textfield',
			                                                        fieldLabel: 'Descripción',
			                                                        id:client.id+'-txt-descripcion',
			                                                        labelWidth:70,
			                                                        //readOnly:true,
			                                                        labelAlign:'right',
			                                                        width:'100%',
			                                                        anchor:'100%'
			                                                    }
			                                                ]
			                                            },
			                                            {
		                                               		width: 150,border:false,
		                                                	padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
		                                             		items:[
				                                                    {
				                                                        xtype:'combo',
				                                                        fieldLabel: 'Estado',
				                                                        id:client.id+'-txt-estado',
				                                                        store: store_estado_lote,
				                                                        queryMode: 'local',
				                                                        triggerAction: 'all',
				                                                        valueField: 'code',
				                                                        displayField: 'name',
				                                                        emptyText: '[Seleccione]',
				                                                        labelAlign:'right',
				                                                        //allowBlank: false,
				                                                        labelWidth: 60,
				                                                        width:'100%',
				                                                        anchor:'100%',
				                                                        //readOnly: true,
				                                                        listeners:{
				                                                            afterrender:function(obj, e){
				                                                                // obj.getStore().load();
				                                                                Ext.getCmp(client.id+'-txt-estado').setValue('1');
				                                                            },
				                                                            select:function(obj, records, eOpts){
				                                                    
				                                                            }
				                                                        }
				                                                    }
		                                             		]
		                                                },
		                                                {
															id: client.id + '-grabar',
															margin:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
									                        xtype:'button',
									                        width:80,
									                        text: 'Grabar',
									                        icon: '/images/icon/save.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                                /*global.permisos({
									                                    id: 15,
									                                    id_btn: obj.getId(), 
									                                    id_menu: gestion_devolucion.id_menu,
									                                    fn: ['panel_asignar_gestion.limpiar']
									                                });
									                            },
									                            click: function(obj, e){
																	client.set_client(3,'¿Está seguro de guardar?');

									                            }
									                        }
									                    },
									                    {
															//id: client.id + '-cancelar',
															margin:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
									                        xtype:'button',
									                        width:80,
									                        text: 'Limpiar',
									                        icon: '/images/icon/broom.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                                //*global.permisos({
									                                //    id: 15,
									                                //    id_btn: obj.getId(), 
									                                //    id_menu: gestion_devolucion.id_menu,
									                                //    fn: ['panel_asignar_gestion.limpiar']
									                                //});

									                                
									                            },
									                            click: function(obj, e){
																	client.set_lotizer_clear();
									                            }
									                        }
									                    }
			                                            
			                                        ]
			                                    }
											]
										},



										{
											region:'center',
											border:false,
											layout:'fit',
											items:[
												{
							                        xtype: 'grid',
							                        //collapsible: true,
											        useArrows: true,
											        rootVisible: true,
											        multiSelect: true,
											        //root:'Task',
							                        id: client.id + '-grid',
							                        //height: 370,
							                        //reserveScrollbar: true,
							                        //rootVisible: false,
							                        //store: store,
							                        //layout:'fit',
							                        columnLines: true,
							                        store: storeTree,
										            columns: [
											            {
											            	//xtype: 'treecolumn',
						                                    text: 'id_Cliente',
						                                    id:client.id+'-shi_codigo',
						                                    dataIndex: 'shi_codigo',
						                                    sortable: true,
						                                    width: 150
						                                },
						                                {
						                                    text: 'Nombre',
						                                    dataIndex: 'shi_nombre',
						                                    flex : 2
						                                },
						                                {
						                                    text: 'Fecha Ingreso',
						                                    dataIndex: 'fec_ingreso',
						                                    width: 200,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'usuario',
						                                    dataIndex: 'id_user',
						                                    width: 150,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Fecha Update',
						                                    dataIndex: 'fecact',
						                                    width: 200,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Estado',
						                                    dataIndex: 'shi_estado',
						                                    loocked : true,
						                                    width: 200,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        metaData.style = "padding: 0px; margin: 0px";
						                                        var estado = (record.get('shi_estado')=='1')?'check-circle-green-16.png':'check-circle-red.png';
						                                        var qtip = (record.get('shi_estado')=='1')?'Estado del Lote Activo.':'Estado del Lote Inactivo.';
						                                        return global.permisos({
						                                            type: 'link',
						                                            id_menu: client.id_menu,
						                                            icons:[
						                                                {id_serv: 9, img: estado, qtip: qtip, js: ""}
						                                            ]
						                                        });
						                                    }
						                                },
						                                {
						                                    text: 'Editar',
						                                    dataIndex: 'shi_estado',
						                                    //loocked : true,
						                                    width: 200,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        	var clienteform = record.get('shi_nombre');
						                                        	var estadoform = record.get('shi_estado');
						                                        	var codigoform = record.get("shi_codigo")
						                                        	client.shi_nombre = record.get('shi_nombre');
						                                        	client.shi_estado = record.get('shi_estado');
						                                        
						                                        if(record.get('shi_estado') == '1'){
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: client.id_menu,

																	

							                                            icons:[
							                                                {id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.getFormMant('U','"+clienteform+"','"+estadoform+"','"+codigoform+"')"},

							                                               //{id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.setEditLote("+rowIndex+",'U')"},


							                                                {id_serv: 9, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "client.setEditLote("+rowIndex+",'D')"}
							                                            ]
							                                        });
							                                    }else{
						                                        	return '';
						                                        }
						                                    }
						                                }
											        ],
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
							                                
							                            },
														beforeselect:function(obj, record, index, eOpts ){
														}
							                        }
							                    }
											]
										},*/

										
										{
											region:'center',
											border:false,
											layout:'fit',
											items:[
												{
							                        xtype: 'treepanel',
											        useArrows: true,
											        rootVisible: true,
											        multiSelect: true,
							                        id: client.id + '-gridTree',
							                        columnLines: true,
							                        store: storeTree2,
										            columns: [
											            {
											            	xtype: 'treecolumn',
						                                    text: 'id_Cliente',
						                                    dataIndex: 'shi_codigo',
						                                    sortable: true,
						                                    width: 80
						                                },
						                                {
						                                    text: 'Nombre',
						                                    dataIndex: 'shi_nombre',
						                                    flex: 300
						                                },

						                                {
						                                    text: 'Editar Cliente',
						                                    dataIndex: 'estado',
						                                    //loocked : true,
						                                    width: 150,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        if(parseInt(record.get('nivel')) == 1){
						                                        	var clienteform = record.get('shi_nombre');
						                                        	var estadoform = record.get('shi_estado');
						                                        	var codigoform = record.get("shi_codigo")
						                                        	client.shi_nombre = record.get('shi_nombre');
						                                        	client.shi_estado = record.get('shi_estado');
						                                        
								                                        if(record.get('shi_estado') == '1'){
									                                        metaData.style = "padding: 0px; margin: 0px";
									                                        return global.permisos({
									                                            type: 'link',
									                                            id_menu: client.id_menu,

																			

									                                            icons:[
									                                                {id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.getFormMant('U','"+clienteform+"','"+estadoform+"','"+codigoform+"')"},

									                                               //{id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.setEditLote("+rowIndex+",'U')"},


									                                                {id_serv: 9, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "client.setEditLote("+rowIndex+",'D')"}
									                                            ]
									                                        });
									                                    }else{
								                                        	return '';
								                                        }
							                                    }else{
						                                        	return '';
						                                        }
						                                    }
						                                },

						                                {
						                                    text: 'id_Contrato',
						                                    dataIndex: 'cod_contrato',
						                                    width: 80,
						                                    align: 'center'
						                                },

						                                {
						                                    text: 'Contrato',
						                                    dataIndex: 'pro_descri',
						                                    width: 300,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Editar Contrato',
						                                    dataIndex: 'estadoC',
						                                    //loocked : true,
						                                    width: 150,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        if(parseInt(record.get('nivel')) == 1){
						                                        	var clienteform = record.get('shi_nombre');
						                                        	var estadoform = record.get('shi_estado');
						                                        	var codigoform = record.get("shi_codigo")
						                                        	client.shi_nombre = record.get('shi_nombre');
						                                        	client.shi_estado = record.get('shi_estado');
						                                        
								                                        if(record.get('shi_estado') == '1'){
									                                        metaData.style = "padding: 0px; margin: 0px";
									                                        return global.permisos({
									                                            type: 'link',
									                                            id_menu: client.id_menu,

																			

									                                            icons:[
									                                                {id_serv: 9, img: 'add.png', qtip: 'Click para Nuevo Contrato.', js: "client.getFormMant('I','"+clienteform+"','"+estadoform+"','"+codigoform+"')"}

									                                            ]
									                                        });
									                                    }
									                                    else
									                                    {
									                                    }
							                                    }else{
							                                    	 if(record.get('shi_estado') == '1'){
									                                        metaData.style = "padding: 0px; margin: 0px";
									                                        return global.permisos({
									                                            type: 'link',
									                                            id_menu: client.id_menu,

																			

									                                            icons:[

									                                                {id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Contrato.', js: "client.getFormMant('U','"+clienteform+"','"+estadoform+"','"+codigoform+"')"},

									                                               //{id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.setEditLote("+rowIndex+",'U')"},


									                                                {id_serv: 9, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Contrato.', js: "client.setEditLote("+rowIndex+",'D')"}
									                                            ]

								                                        });
									                                }        		
						                                        	//return '';
						                                        }
						                                    }
						                                },



						                                {
						                                    text: 'Fecha Ingreso',
						                                    dataIndex: 'fec_ingreso',
						                                    width: 150,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'User',
						                                    dataIndex: 'id_user',
						                                    width: 120,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Fecha Update',
						                                    dataIndex: 'fecact',
						                                    width: 150,
						                                    align: 'center'
						                                },



						                                {
						                                    text: 'Estado Registro',
						                                    dataIndex: 'shi_estado',
						                                    loocked : true,
						                                    width: 100,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        metaData.style = "padding: 0px; margin: 0px";
						                                        var estado = (record.get('shi_estado')=='1')?'check-circle-green-16.png':'check-circle-red.png';
						                                        var qtip = (record.get('shi_estado')=='1')?'Estado del Lote Activo.':'Estado del Lote Inactivo.';
						                                        return global.permisos({
						                                            type: 'link',
						                                            id_menu: client.id_menu,
						                                            icons:[
						                                                {id_serv: 9, img: estado, qtip: qtip, js: ""}
						                                            ]
						                                        });
						                                    }
						                                }

/*
						                                {
						                                    text: 'Editar',
						                                    dataIndex: 'shi_estado',
						                                    //loocked : true,
						                                    width: 200,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        	var clienteform = record.get('shi_nombre');
						                                        	var estadoform = record.get('shi_estado');
						                                        	var codigoform = record.get("shi_codigo")
						                                        	client.shi_nombre = record.get('shi_nombre');
						                                        	client.shi_estado = record.get('shi_estado');
						                                        
						                                        if(record.get('shi_estado') == '1'){
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: client.id_menu,

																	

							                                            icons:[
							                                                {id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.getFormMant('U','"+clienteform+"','"+estadoform+"','"+codigoform+"')"},

							                                               //{id_serv: 9, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.setEditLote("+rowIndex+",'U')"},


							                                                {id_serv: 9, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "client.setEditLote("+rowIndex+",'D')"}
							                                            ]
							                                        });
							                                    }else{
						                                        	return '';
						                                        }
						                                    }
						                                }

*/


											        ],
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
	
							                                
							                            },
														beforeselect:function(obj, record, index, eOpts ){

														}
							                        }
							                    }
											]
										}
										

											


									]
									
								}
							]
						}
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(client.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                    	//lotizer.getReloadGridlotizer('');
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,client.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(client.id_menu, false);
	                    }
					}

				}).show();
			},
			getImagen:function(param){
				/*win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/lotizer/'+param}});*/
			},
			setEditLote:function(index,op){
				var rec = Ext.getCmp(client.id + '-gridTree').getStore().getAt(index);
			/*	client.id_lote=rec.data.id_lote;*/
			//	var shi_codigo = Ext.getCmp(client.id+'-shi_codigo').getValue();
			/*	var fac_cliente = Ext.getCmp(client.id+'-cbx-contrato').getValue();
				if(rec.data.shi_codigo!=shi_codigo){
					Ext.getCmp(client.id+'-cbx-cliente').setValue(rec.data.shi_codigo);
					Ext.getCmp(client.id+'-cbx-contrato').setValue('');
					client.getContratos(rec.data.shi_codigo);
				}
				Ext.getCmp(client.id+'-cbx-contrato').setValue(rec.data.fac_cliente);
				client.shi_codigo=rec.data.shi_codigo;
				client.fac_cliente=rec.data.fac_cliente;
			*/
				client.shi_codigo = (rec.data.shi_codigo)
				client.opcion=op;
				if(op!='D'){

					Ext.getCmp(client.id+'-txt-nombre').setValue(rec.data.shi_nombre);
					//Ext.getCmp(client.id+'-txt-descripcion').setValue(rec.data.descripcion);
				  	Ext.getCmp(client.id+'-txt-estado').setValue(rec.data.shi_estado);
				  	//Ext.getCmp(client.id+'-txt-tot_folder').setValue(rec.data.tot_folder);
				  	Ext.getCmp(client.id+'-txt-nombre').focus(true);
					//console.log(rec.data);
				}else{
					client.set_client(2,'¿Está seguro de Desactivar?');
				}
			},
			set_lotizer_clear:function(){
				Ext.getCmp(client.id+'-txt-estado-filter').setValue(' ');
				Ext.getCmp(client.id+'-txt-fecha-filtro').setValue('Y-m-d');
				Ext.getCmp(client.id+'-txt-cliente').setValue('');
			  	//client.id_lote=0;
			  	client.shi_codigo=0;
				//client.fac_cliente=0;
				client.opcion='I';
				Ext.getCmp(client.id+'-txt-cliente').focus(true);
			},

			set_lotizer_clearform:function(){
				Ext.getCmp(client.id+'-txt-nombre').setValue('');
			  	Ext.getCmp(client.id+'-txt-estado').setValue('1');
			  	//client.id_lote=0;
			  	//client.shi_codigo=0;
				//client.fac_cliente=0;
				//client.opcion='I';
				Ext.getCmp(client.id+'-txt-nombre').focus(true);
			},





			setValidaLote:function(){
				if(client.opcion=='I' || client.opcion=='U'){
					/*var shi_codigo = Ext.getCmp(client.id+'-cbx-cliente').getValue();
					if(shi_codigo== null || shi_codigo==''){
			            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        client.shi_codigo=shi_codigo;
					var fac_cliente = Ext.getCmp(client.id+'-cbx-contrato').getValue();
					if(fac_cliente== null || fac_cliente==''){
			            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        client.fac_cliente=fac_cliente;*/
					var nombre = Ext.getCmp(client.id+'-txt-nombre').getValue();
					if(nombre== null || nombre==''){
			            global.Msg({msg:"Ingrese un nombre por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        var estado = Ext.getCmp(client.id+'-txt-estado').getValue();
			        if(estado== null || estado==''){
			            global.Msg({msg:"Ingrese un estado por favor.",icon:2,fn:function(){}});
			            return false; 
			        }/*
				  	var total = Ext.getCmp(client.id+'-txt-tot_folder').getValue();
				  	if(total== null || total==0 || total==''){
			            global.Msg({msg:"Ingrese el total de folderes por favor.",icon:2,fn:function(){}});
			            return false;
			        }*/
			    }
		        return true;
			},
			set_client:function(ico,msn){
				if(!client.setValidaLote())return;
				global.Msg({
                    msg: msn,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(client.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
	                        Ext.Ajax.request({
								url: client.url + 'set_client/',
								params:{
									vp_op: client.opcion,
									vp_shi_codigo:client.shi_codigo,
									/*
									vp_fac_cliente:client.fac_cliente,
			                        vp_id_lote:client.id_lote,*/
			                        vp_nombre:client.shi_nombre,
			                        /*vp_descripcion:Ext.getCmp(client.id+'-txt-descripcion').getValue(),
			                        vp_tipdoc:Ext.getCmp(client.id+'-txt-tipdoc').getValue(),
			                        vp_lote_fecha:Ext.getCmp(client.id+'-txt-fecha').getValue(),
			                        vp_ctdad:Ext.getCmp(client.id+'-txt-tot_folder').getValue(),*/
			                        vp_estado:client.shi_estado
			                        //vp_estado:Ext.getCmp(client.id+'-txt-estado').getValue()
								},
								success:function(response,options){
									var res = Ext.decode(response.responseText);
									Ext.getCmp(client.id+'-tab').el.unmask();
									//console.log(res);
									///*****Terrestre****//
									global.Msg({
		                                msg: res.msn,
		                                icon: parseInt(res.error),
		                                buttons: 1,
		                                fn: function(btn){
		                                    if(parseInt(res.error)==1){
		                                    	if (client.opcion == 'U' || client.opcion == 'I') {
		                                    	Ext.getCmp(client.id+'-win-form').close();
		                                    	}
		                                    	//Ext.getCmp(client.id+'-win-form').el.mask('Cargando…', 'x-mask-loading');
		                                    	client.getReloadGridlotizer('');
		                                    	client.set_lotizer_clear();
		                                    }
		                                }
		                            });
				    			}
				    		});
				    	}
		            }
                });
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(client.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(client.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(lotizer.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridlotizer:function(name,fecha,estado){
				//lotizer.set_lotizer_clear();
				//Ext.getCmp(lotizer.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				/*var shi_codigo = Ext.getCmp(lotizer.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(lotizer.id+'-cbx-contrato').getValue();*/
				//var name = Ext.getCmp(lotizer.id+'-nombre').getValue();
				/*var estado = Ext.getCmp(lotizer.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(lotizer.id+'-txt-fecha-filtro').getRawValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }

				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }*/

				Ext.getCmp(client.id + '-gridTree').getStore().load(
	                {params: {vp_name:name,vp_date:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(lotizer.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridlotizer2:function(id_lote){
				Ext.getCmp(client.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				//id:lotizer.id+'-form'
				Ext.getCmp(client.id + '-grid-client').getStore().load(
	                {params: {vp_id_lote:id_lote},
	                callback:function(){
	                	Ext.getCmp(client.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				//lotizer.shi_codigo=0;
				//lotizer.getImagen('default.png');
//					                        icon: '/images/icon/save.png',

				Ext.getCmp(client.id+'-txt-nombre').setValue('');
				Ext.getCmp(client.id+'-txt-nombre').setReadOnly(false);
				Ext.getCmp(client.id+'-txt-tipdoc').setValue('');
				Ext.getCmp(client.id+'-txt-tipdoc').setReadOnly(false);
				Ext.getCmp(client.id+'-txt-fecha').setValue('');
				Ext.getCmp(client.id+'-txt-fecha').setReadOnly(false);
				Ext.getCmp(client.id+'-txt-estado').setValue('');
				Ext.getCmp(client.id+'-txt-estado').setReadOnly(false);
				Ext.getCmp(client.id+'-txt-tot_folder').setValue('');
				Ext.getCmp(client.id+'-txt-tot_folder').setReadOnly(false);
				Ext.getCmp(client.id+'-txt-nombre').focus();
			},

			getFormMant:function(op,cliente,estado,codigo){
				client.shi_codigo = codigo;
				client.opcion = op;
				if (op == 'U') {
					var titulo = 'Edición';
					var icono = "/images/icon/edit.png";
					var oculto = "false";
				} 
				else
				{
					var titulo = 'Nuevo';
					var icono = "/images/icon/add_green_button.png";	
					var oculto = "true";
				}


				var myData = [
				    ['1','Activo'],
				    ['0','Inactivo']
				];
				var store_estado = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'estado',
			        autoLoad: true,
			        data: myData,
			        fields: ['code', 'name']
			    });

				Ext.create('Ext.window.Window',{
	                id:client.id+'-win-form',
	                plain: true,
	                title:titulo,
	                icon: icono,
	                height: 200,
	                width: 1000,
	                resizable:false,
	                modal: true,
	                border:false,
	                closable:true,
	                padding:20,
	                items:[

												{
			                                        xtype: 'fieldset',
			                                        margin: '5 5 5 10',
			                                        title:'<b>Mantenimiento Clientes</b>',
			                                        border:true,
			                                        bodyStyle: 'background: transparent',
			                                        padding:'2px 5px 1px 5px',
			                                        layout:'column',
			                                        items: [
			                                            {	
			                                            	hidden : oculto,	
			                                                columnWidth: .3,border:false,
			                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
			                                                items:[
			                                                    {
			                                                        xtype: 'textfield',
			                                                        fieldLabel: 'id_Cliente',
			                                                        //id:client.id+'-txt-nombre',
			                                                        labelWidth:50,
			                                                        readOnly:true,
			                                                        labelAlign:'right',
			                                                        width:'100%',
			                                                        anchor:'100%',
			                                                        value:codigo
			                                                    }
			                                                ]
			                                            },

			                                            {
			                                                columnWidth: .3,border:false,
			                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
			                                                items:[
			                                                    {
			                                                        xtype: 'textfield',
			                                                        fieldLabel: 'Cliente',
			                                                        id:client.id+'-txt-nombre',
			                                                        labelWidth:60,
			                                                        //readOnly:true,
			                                                        labelAlign:'right',
			                                                        width:'100%',
			                                                        anchor:'100%',
			                                                        value:cliente
			                                                    }
			                                                ]
			                                            },
			                                            {
		                                               		width: 150,border:false,
		                                                	padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
		                                             		items:[
				                                                    {
				                                                        xtype:'combo',
				                                                        fieldLabel: 'Estado',
				                                                        id:client.id+'-txt-estado',
				                                                        store: store_estado,
				                                                        queryMode: 'local',
				                                                        triggerAction: 'all',
				                                                        valueField: 'code',
				                                                        displayField: 'name',
				                                                        emptyText: '[Seleccione]',
				                                                        labelAlign:'right',
				                                                        value:estado,
				                                                        //allowBlank: false,
				                                                        labelWidth: 60,
				                                                        width:'100%',
				                                                        anchor:'100%',
				                                                        //readOnly: true,
				                                                        listeners:{
				                                                            afterrender:function(obj, e){
				                                                                // obj.getStore().load();
				                                                                Ext.getCmp(client.id+'-txt-estado').setValue('1');
				                                                            },
				                                                            select:function(obj, records, eOpts){
				                                                    
				                                                            }
				                                                        }
				                                                    }
		                                             		]
		                                                },
									                    {
															//id: client.id + '-cancelar',
															margin:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
									                        xtype:'button',
									                        width:80,
									                        text: 'Limpiar',
									                        icon: '/images/icon/broom.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                                /*global.permisos({
									                                //    id: 15,
									                                //    id_btn: obj.getId(), 
									                                //    id_menu: gestion_devolucion.id_menu,
									                                //    fn: ['panel_asignar_gestion.limpiar']
									                                //});*/

									                                
									                            },
									                            click: function(obj, e){
																	client.set_lotizer_clearform();
									                            }
									                        }
									                    }
			                                            
			                                        ]
			                                    }



	                	/*{
	                        xtype: 'textfield',
	                        id:client.id+'-grid-client-form',
	                        fieldLabel: 'Cod_Lote',
	                        //disabled:true,
	                        labelWidth:90,
	                        labelAlign:'right',
	                        width:'100%',
	                        anchor:'100%',
	                        value:cod_lote
	                    },
	                    {
	                        xtype: 'textfield',
	                        id:client.id+'-form-descripcion',
	                        fieldLabel: 'Descripción',
	                        labelWidth:90,
	                        labelAlign:'right',
	                        width:'100%',
	                        anchor:'100%',
	                        value:descripcion
	                    },
	                    {
	                        xtype:'combo',
	                        fieldLabel: 'Estado',
	                        id:formularioGestion.id+'-form-cmb-estado',
	                        store: store_estado,
	                        queryMode: 'local',
	                        triggerAction: 'all',
	                        valueField: 'code',
	                        displayField: 'name',
	                        emptyText: '[Seleccione]',
	                        labelAlign:'right',
	                        //allowBlank: false,
	                        labelWidth: 90,
	                        width:'100%',
	                        anchor:'100%',
	                        //readOnly: true,
	                        listeners:{
	                            afterrender:function(obj, e){
	                                // obj.getStore().load();
	                                if(ID==0){
	                                	obj.setValue(1);
	                                }else{
	                                	obj.setValue(estado);
	                                }
	                            },
	                            select:function(obj, records, eOpts){
	                    
	                            }
	                        }
	                    }*/
	                ],
	                bbar:[       
		                                                {

															id: client.id + '-grabar',
															margin:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
									                        xtype:'button',
									                        width:80,
									                        text: 'Grabar',
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
									                            	client.shi_estado = Ext.getCmp(client.id+'-txt-estado').getValue();
									                           		client.shi_nombre = Ext.getCmp(client.id+'-txt-nombre').getValue();
									                           		//cliente;

																	client.set_client(3,'¿Está seguro de guardar?');


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
	                                /*global.permisos({
	                                    id: 15,
	                                    id_btn: obj.getId(), 
	                                    id_menu: gestion_devolucion.id_menu,
	                                    fn: ['panel_asignar_gestion.limpiar']
	                                });*/
	                            },
	                            click: function(obj, e){
	                                Ext.getCmp(client.id+'-win-form').close();
	                            }
	                        }
	                    },
	                    '-'
	                ],
	                listeners:{
	                    'afterrender':function(obj, e){ 
	                        //panel_asignar_gestion.getDatos();
	                    },
	                    'close':function(){
	                        //if(panel_asignar_gestion.guarda!=0)gestion_devolucion.buscar();
	                    }
	                },

	            }).show().center();

			}

		}
		Ext.onReady(client.init,client);
		Ext.getCmp(client.id+'-txt-cliente').focus(true);

	}else{
		tab.setActiveTab(client.id+'-tab');
	}
</script>