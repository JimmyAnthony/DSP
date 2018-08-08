<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('client-tab')){
		var client = {
			id:'client',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/client/',
			opcion:'I',
			//id_lote:0,
			//shi_codigo:0,
			//fac_cliente:0,
			init:function(){
/*				Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
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
	                    url: lotizer.url+'get_list_lotizer/'//,

	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {

					    },
	                    load: function(obj, records, successful, opts){
	                 		Ext.getCmp(lotizer.id + '-grid').doLayout();
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(lotizer.id + '-grid').collapseAll();
		                    Ext.getCmp(lotizer.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
	                    }
	                }
	            });
*/
				var storeTree = new Ext.data.TreeStore({
	                fields: [
	                	{name: 'shi_codigo', type: 'string'},
	                    {name: 'shi_nombre', type: 'string'},
	                    {name: 'fec_ingreso', type: 'string'},
	                    {name: 'estado', type: 'string'},
						{name: 'usr_id', type: 'string'},	                    
	                    {name: 'fecha_actual', type: 'string'}
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
                            height:90,
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
		                            height:90,
		                            items:[
		                                {
		                                    xtype:'panel',
		                                    border:false,
		                                    bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',

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
		                                                }
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
			                                                value:new Date(),
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
			                                                            Ext.getCmp(client.id+'-txt-estado-filter').setValue('L');
			                                                        },
			                                                        select:function(obj, records, eOpts){
			                                                
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
		                                        {
		                                            width: 80,border:false,
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
									                            	var estado = Ext.getCmp(client.id+'-txt-estado-filter').getValue();	


		                               					            client.getReloadGridlotizer(name,fecha,estado);
									                            }
									                        }
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
							layout:'border',
							items:[
								{
									region:'center',
									//width:'100%',
									layout:'border',
									items:[
										{
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
			                                                width: 150,border:false,hidden:true,
			                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
			                                                items:[
			                                                    {
			                                                        xtype: 'textfield',
			                                                        fieldLabel: 'Total Folders',
			                                                        id:client.id+'-txt-tot_folder',
			                                                        labelWidth:100,
			                                                        //readOnly:true,
			                                                        labelAlign:'right',
			                                                        maskRe: /[0-9]/,
			                                                        width:'100%',
			                                                        anchor:'100%'
			                                                    }
			                                                ]
			                                            },
			                                            {
			                                                width: 1,border:false,hidden:true,
			                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
			                                                items:[
			                                                    {
			                                                        xtype: 'textfield',
			                                                        fieldLabel: 'Tipo Doc',
			                                                        id:client.id+'-txt-tipdoc',
			                                                        labelWidth:100,
			                                                        readOnly:true,
			                                                        labelAlign:'right',
			                                                        width:'100%',
			                                                        anchor:'100%'
			                                                    }
			                                                ]
			                                            },

			                                            {
			                                                width: 160,border:false,hidden:true,
			                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
			                                                items:[
			                                                    {
			                                                        xtype:'datefield',
			                                                        id:client.id+'-txt-fecha',
			                                                        fieldLabel:'Fecha',
			                                                        labelWidth:60,
			                                                        labelAlign:'right',
			                                                        value:new Date(),
			                                                        format: 'Ymd',
			                                                        readOnly:true,
			                                                        width: '100%',
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
				                                                                Ext.getCmp(client.id+'-txt-estado').setValue('L');
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
									                                });*/
									                            },
									                            click: function(obj, e){
																	client.set_lotizer(3,'¿Está seguro de guardar?');

									                            }
									                        }
									                    },
									                    {
															id: client.id + '-cancelar',
															margin:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
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
											            /*{
											                xtype: 'treecolumn', //this is so we know which column will show the tree
											                text: 'Task',
											                flex: 2,
											                sortable: true,
											                dataIndex: 'task'
											            },*/
											            {
											            	//xtype: 'treecolumn',
						                                    text: 'id_Cliente',
						                                  //  id:lotizer.id+'-nombre',
						                                    dataIndex: 'shi_codigo',
						                                    sortable: true,
						                                    flex: 1
						                                },
						                                {
						                                    text: 'Nombre',
						                                    dataIndex: 'shi_nombre',
						                                    flex: 2
						                                },
						                                {
						                                    text: 'Fecha Ingreso',
						                                    dataIndex: 'fec_ingreso',
						                                    width: 180,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'id_user',
						                                    dataIndex: 'usr_id',
						                                    width: 80,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Fecha Update',
						                                    dataIndex: 'fecha_actual',
						                                    width: 80,
						                                    align: 'center'
						                                },
						                                {	hidden:true,
						                                    text: 'Total Pag. Errores',
						                                    dataIndex: 'tot_errpag',
						                                    width: 100,
						                                    align: 'center'
						                                },
						                                {
						                                	hidden:true,
						                                    text: 'User',
						                                    dataIndex: 'usr_update',
						                                    width: 100,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Estado',
						                                    dataIndex: 'estado',
						                                    loocked : true,
						                                    width: 50,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        metaData.style = "padding: 0px; margin: 0px";
						                                        var estado = (record.get('estado')=='1')?'check-circle-green-16.png':'check-circle-red.png';
						                                        var qtip = (record.get('estado')=='1')?'Estado del Lote Activo.':'Estado del Lote Inactivo.';
						                                        return global.permisos({
						                                            type: 'link',
						                                            id_menu: client.id_menu,
						                                            icons:[
						                                                {id_serv: 1, img: estado, qtip: qtip, js: ""}
						                                            ]
						                                        });
						                                    }
						                                },
						                                {
						                                    text: 'Editar',
						                                    dataIndex: 'estado',
						                                    //loocked : true,
						                                    width: 50,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        if(record.get('estado') == '1'){
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: client.id_menu,
							                                            icons:[
							                                                {id_serv: 1, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "client.setEditLote("+rowIndex+",'U')"},
							                                                {id_serv: 1, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "client.setEditLote("+rowIndex+",'D')"}
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
							                                //lotizer.getImagen('default.png');
							                                
							                            },
														beforeselect:function(obj, record, index, eOpts ){
															//console.log(record);
															/*lotizer.opcion='U';*/
															/*lotizer.id_lote=record.get('id_lote');
															/*lotizer.getImagen(record.get('imagen'));*/
															/*Ext.getCmp(lotizer.id+'-txt-nombre').setValue(record.get('nombre'));
															Ext.getCmp(lotizer.id+'-txt-tipdoc').setValue(record.get('tipdoc'));
															Ext.getCmp(lotizer.id+'-txt-fecha').setValue(record.get('fecha'));
															Ext.getCmp(lotizer.id+'-txt-estado').setValue(record.get('estado'));
															Ext.getCmp(lotizer.id+'-txt-tot_folder').setValue(record.get('tot_folder'));

															Ext.getCmp(lotizer.id+'-txt-nombre').setReadOnly(true);
															Ext.getCmp(lotizer.id+'-txt-tipdoc').setReadOnly(true);
															Ext.getCmp(lotizer.id+'-txt-fecha').setReadOnly(true);
															Ext.getCmp(lotizer.id+'-txt-estado').setReadOnly(true);
															Ext.getCmp(lotizer.id+'-txt-tot_folder').setReadOnly(true);


															var botonTxt = Ext.getCmp('boton').getText();
															if (botonTxt == 'Guardar' || botonTxt == 'Update') {
																Ext.getCmp('boton').setText('Editar');
																Ext.getCmp('boton').setIcon('/images/icon/editar.png');
															}*/

															//lotizer.getReloadGridlotizer2(lotizer.id_lote);

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
				var rec = Ext.getCmp(client.id + '-grid').getStore().getAt(index);
				client.id_lote=rec.data.id_lote;
				var shi_codigo = Ext.getCmp(client.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(client.id+'-cbx-contrato').getValue();
				if(rec.data.shi_codigo!=shi_codigo){
					Ext.getCmp(client.id+'-cbx-cliente').setValue(rec.data.shi_codigo);
					Ext.getCmp(client.id+'-cbx-contrato').setValue('');
					client.getContratos(rec.data.shi_codigo);
				}
				Ext.getCmp(client.id+'-cbx-contrato').setValue(rec.data.fac_cliente);
				client.shi_codigo=rec.data.shi_codigo;
				client.fac_cliente=rec.data.fac_cliente;

				client.opcion=op;
				if(op!='D'){
					Ext.getCmp(client.id+'-txt-nombre').setValue(rec.data.nombre);
					Ext.getCmp(client.id+'-txt-descripcion').setValue(rec.data.descripcion);
				  	Ext.getCmp(client.id+'-txt-estado').setValue(rec.data.estado);
				  	Ext.getCmp(client.id+'-txt-tot_folder').setValue(rec.data.tot_folder);
				  	Ext.getCmp(client.id+'-txt-nombre').focus(true);
					//console.log(rec.data);
				}else{
					client.set_lotizer(2,'¿Está seguro de Desactivar?');
				}
			},
			set_lotizer_clear:function(){
				Ext.getCmp(client.id+'-txt-nombre').setValue('');
				Ext.getCmp(client.id+'-txt-descripcion').setValue('');
			  	Ext.getCmp(client.id+'-txt-estado').setValue('L');
			  	Ext.getCmp(client.id+'-txt-tot_folder').setValue(0);
			  	client.id_lote=0;
			  	client.shi_codigo=0;
				client.fac_cliente=0;
				client.opcion='I';
				Ext.getCmp(client.id+'-txt-nombre').focus(true);
			},
			setValidaLote:function(){
				if(client.opcion=='I' || client.opcion=='U'){
					var shi_codigo = Ext.getCmp(client.id+'-cbx-cliente').getValue();
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
			        client.fac_cliente=fac_cliente;
					var nombre = Ext.getCmp(client.id+'-txt-nombre').getValue();
					if(nombre== null || nombre==''){
			            global.Msg({msg:"Ingrese un nombre por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        var estado = Ext.getCmp(client.id+'-txt-estado').getValue();
			        if(estado== null || estado==''){
			            global.Msg({msg:"Ingrese un estado por favor.",icon:2,fn:function(){}});
			            return false; 
			        }
				  	var total = Ext.getCmp(client.id+'-txt-tot_folder').getValue();
				  	if(total== null || total==0 || total==''){
			            global.Msg({msg:"Ingrese el total de folderes por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			    }
		        return true;
			},
			set_lotizer:function(ico,msn){
				if(!client.setValidaLote())return;
				global.Msg({
                    msg: msn,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(client.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
	                        Ext.Ajax.request({
								url: client.url + 'set_lotizer/',
								params:{
									vp_op: client.opcion,
									vp_shi_codigo:client.shi_codigo,
									vp_fac_cliente:client.fac_cliente,
			                        vp_id_lote:client.id_lote,
			                        vp_nombre:Ext.getCmp(client.id+'-txt-nombre').getValue(),
			                        vp_descripcion:Ext.getCmp(client.id+'-txt-descripcion').getValue(),
			                        vp_tipdoc:Ext.getCmp(client.id+'-txt-tipdoc').getValue(),
			                        vp_lote_fecha:Ext.getCmp(client.id+'-txt-fecha').getValue(),
			                        vp_ctdad:Ext.getCmp(client.id+'-txt-tot_folder').getValue(),
			                        vp_estado:Ext.getCmp(client.id+'-txt-estado').getValue()
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
				Ext.getCmp(client.id + '-grid').getStore().load(
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

			getFormMant:function(cod_lote,lote,usuario,cantidad){
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
	                title:'Edición',
	                icon: '/images/icon/edit.png',
	                height: 200,
	                width: 450,
	                resizable:false,
	                modal: true,
	                border:false,
	                closable:true,
	                padding:20,
	                items:[
	                	{
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
	                    }
	                ],
	                bbar:[       
	                    '->',
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Guardar',
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
	                            	formularioGestion.setSaveRecordForm(ID);
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
	                                Ext.getCmp(formularioGestion.id+'-win-form').close();
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
	                }
	            }).show().center();
			}

		}
		Ext.onReady(client.init,client);
	}else{
		tab.setActiveTab(client.id+'-tab');
	}
</script>