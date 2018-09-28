<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('return-tab')){
		var ireturn = {
			id:'ireturn',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/return/',
			opcion:'I',
			id_lote:0,
			shi_codigo:0,
			fac_cliente:0,
			id_dev:0,
			paramsStore:{},
			paramsStorePRE:{},
			init:function(){
				Ext.tip.QuickTipManager.init();

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'hijo', type: 'string'},
				        {name: 'padre', type: 'string'},
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'lot_estado', type: 'string'},
	                    {name: 'tipdoc', type: 'string'},
	                    {name: 'nombre', type: 'string'},
	                    {name: 'lote_nombre', type: 'string'},
	                    {name: 'descripcion', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'img', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'tot_folder', type: 'string'},
	                    {name: 'tot_pag', type: 'string'},
	                    {name: 'tot_errpag', type: 'string'},
	                    {name: 'id_user', type: 'string'},
	                    {name: 'usr_update', type: 'string'},
	                    {name: 'fec_update', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'nivel', type: 'string'},
	                    {name: 'id_dev', type: 'string'},
	                    {name: 'usr_dev', type: 'string'}
				    ]
				});
				var storeTree = new Ext.data.TreeStore({
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: ireturn.url+'get_list_pending_return/'
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
	                		store.proxy.extraParams = ireturn.paramsStore;
					    },
	                    load: function(obj, records, successful, opts){
		                    Ext.getCmp(ireturn.id + '-grid').doLayout();
	                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(ireturn.id + '-grid').collapseAll();
		                    Ext.getCmp(ireturn.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                    });
		                    Ext.getCmp(ireturn.id + '-grid').expandAll();
	                    }
	                }
	            });

	            Ext.define('Task_pre', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'hijo', type: 'string'},
				        {name: 'padre', type: 'string'},
				        {name: 'id_lote', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'lot_estado', type: 'string'},
	                    {name: 'tipdoc', type: 'string'},
	                    {name: 'nombre', type: 'string'},
	                    {name: 'lote_nombre', type: 'string'},
	                    {name: 'descripcion', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'img', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'tot_folder', type: 'string'},
	                    {name: 'tot_pag', type: 'string'},
	                    {name: 'tot_errpag', type: 'string'},
	                    {name: 'id_user', type: 'string'},
	                    {name: 'usr_update', type: 'string'},
	                    {name: 'fec_update', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'nivel', type: 'string'},
	                    {name: 'id_dev', type: 'string'},
	                    {name: 'usr_dev', type: 'string'}
				    ]
				});
				var storeTreePRE = new Ext.data.TreeStore({
	                model: 'Task_pre',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: ireturn.url+'get_list_pre_return/'
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
	                		store.proxy.extraParams = ireturn.paramsStorePRE;
					    },
	                    load: function(obj, records, successful, opts){
	                    	try{
			                    Ext.getCmp(ireturn.id + '-grid-devoluciones').doLayout();
		                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
		                 		storeTreePRE.removeAt(0);
		                 		Ext.getCmp(ireturn.id + '-grid-devoluciones').collapseAll();
			                    Ext.getCmp(ireturn.id + '-grid-devoluciones').getRootNode().cascadeBy(function (node) {
			                          if (node.getDepth() < 1) { node.expand(); }
			                          if (node.getDepth() == 0) { return false; }
			                    });
			                    Ext.getCmp(ireturn.id + '-grid-devoluciones').expandAll();
			                 }catch(err) {
							    console.log(err.message);
							}

	                    }
	                }
	            });

				var store = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'id_dev', type: 'string'},
	                    {name: 'motivo', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'hora', type: 'string'},
	                    {name: 'responsable', type: 'string'},                    
	                    {name: 'documento', type: 'string'},
	                    {name: 'mensaje', type: 'string'},                    
	                    {name: 'tot_lotes', type: 'string'},
	                    {name: 'tot_folders', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'fecha_registro', type: 'string'},
	                    {name: 'usr_nombre', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: ireturn.url+'get_lista_devoluciones/',
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
                    url: ireturn.url+'get_list_shipper/',
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
                    url: ireturn.url+'get_list_contratos/',
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

		    var myDataMotivos = [
				['EN','Entrega de documentos por fin de proceso'],
			    ['PO','Problemas con documentos no legibles'],
			    ['PE','Perdida de documentos'],
			    ['PD','Pedido de Devolución antes de termino del proceso']
			];
			var store_motivos = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'motivos',
		        autoLoad: true,
		        data: myDataMotivos,
		        fields: ['code', 'name']
		    });
		    
		    var myDataEstadoDevolucion = [
				['P','Pendiente de Cierre'],
			    ['D','Devolución Cerrada'],
			    ['C','Devolución Cancelada']
			];
			var store_estado_devolucion = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado_devolucion',
		        autoLoad: true,
		        data: myDataEstadoDevolucion,
		        fields: ['code', 'name']
		    });

		    

				var panel = Ext.create('Ext.form.Panel',{
					id:ireturn.id+'-form',
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
					id:ireturn.id+'-tab',
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
								{
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
			                                                    id:ireturn.id+'-cbx-cliente',
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
			                                                        },
			                                                        select:function(obj, records, eOpts){
			                                                        	Ext.getCmp(ireturn.id+'-cbx-contrato').setValue('');
			                                                			ireturn.getContratos(records.get('shi_codigo'));
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
			                                                    id:ireturn.id+'-cbx-contrato',
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
			                                                    listeners:{
			                                                        afterrender:function(obj, e){

			                                                        },
			                                                        select:function(obj, records, eOpts){
			                                                			//ireturn.getDevoluciones();
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
		                            xtype: 'uePanelS',
		                            logo: 'LT',
		                            title: 'Listado de Lotes',
		                            legend: 'Búsqueda de Lotes registrados',
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
		                                            width:100,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'N° Lote',
		                                                    id:ireturn.id+'-txt-lote',
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
		                                            width:250,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre Lote',
		                                                    id:ireturn.id+'-txt-lotizer',
		                                                    labelWidth:80,
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
			                                                id:ireturn.id+'-txt-fecha-filtro',
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
			                                                    id:ireturn.id+'-txt-estado-filter',
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

			                                                            Ext.getCmp(ireturn.id+'-txt-estado-filter').setValue('A');
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
									                            },
									                            click: function(obj, e){	             	
		                               					            ireturn.getReloadGridlotizer();
									                            }
									                        }
									                    }
		                                            ]
		                                        }/*,
		                                        {
		                                            width: 80,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
									                        xtype:'button',
									                        text: 'Devolver',
									                        icon: '/images/icon/if_General_Office_36_2530817.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                            },
									                            click: function(obj, e){	
											                    	var records = Ext.getCmp(ireturn.id + '-grid');
																    var objectStore = records.getStore(),
																        dataCollection = [];

																    if (objectStore.data.items !== undefined) {
																    	
																        $.each(objectStore.data.items, function (index, objectData) {
																        	
																            if (!objectData.data.leaf) {

																            } else {
																            	if(objectData.data.done == true) {
																            	var nombre = objectData.data.lote_nombre;
																            	var id_lote = objectData.data.id_lote;
																            	var id_det = objectData.data.id_det;
																            	var arr1 = [nombre,id_lote,id_det] ;
																            	dataCollection.push(arr1);
																                }
																            }
																        })

																    };
																    ireturn.getFormMant(dataCollection);
									                            }
									                        }
									                    }
		                                            ]
		                                        }*/
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
									layout:'border',
									items:[
										{
											region:'center',
											border:false,
											layout:'border',
											items:[
												{
													region:'center',
													padding:'5px 5px 5px 5px',
													title:'Pendientes a Devolución',
													border:true,
													layout:'fit',
													items:[
														{
									                        xtype: 'treepanel',
													        useArrows: true,
													        rootVisible: true,
													        multiSelect: true,
									                        id: ireturn.id + '-grid',
									                        columnLines: true,
									                        store: storeTree,

												            columns: [
													            {
													            	xtype: 'treecolumn',
													            	id: ireturn.id + '-grid-lote_nombre',
								                                    text: 'Nombre',
								                                    dataIndex: 'lote_nombre',
								                                    sortable: true,
								                                    flex: 1
								                                },
								                                /*{
								                                    text: 'Descripción',
								                                    dataIndex: 'descripcion',
								                                    flex: 2
								                                },*/
								                                {
								                                    text: 'Estado Lote',
								                                    dataIndex: 'lot_estado',
								                                    loocked : true,
								                                    width: 80,
								                                    align: 'center'
								                                },
								                                {
								                                    text: 'Acción',
								                                    dataIndex: 'lot_estado',
								                                    loocked : true,
								                                    width: 70,
								                                    align: 'center',
								                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
								                                        metaData.style = "padding: 0px; margin: 0px";
								                                        var estado = 'basket_put.png';
								                                        var qtip = 'Agregar Registro a pre devolución';
								                                        var ser = 7;
								                                        if(parseInt(record.get('id_dev'))!=0){
								                                        	ser=0;
								                                        	estado = 'inicio.png';
								                                        }
																		var id_det = 0;
																		if(parseInt(record.get('nivel'))==2){
																			var id_det = record.get('hijo');
																		}
								                                        return global.permisos({
								                                            type: 'link',
								                                            id_menu: ireturn.id_menu,
								                                            icons:[
								                                                {id_serv: ser, img: estado, qtip: qtip, js: "ireturn.setAddPreReturn('A',"+record.get('shi_codigo')+","+record.get('fac_cliente')+","+id_det+","+record.get('id_lote')+")"}
								                                            ]
								                                        });
								                                    }
								                                },
								                                {
								                                    text: 'Fecha y Hora',
								                                    dataIndex: 'fecha',
								                                    width: 140,
								                                    align: 'center'
								                                },
								                                {
								                                    text: 'Total Folder',
								                                    dataIndex: 'tot_folder',
								                                    width: 80,
								                                    align: 'center'
								                                },/*
								                                {
								                                    text: 'Total Página',
								                                    dataIndex: 'tot_pag',
								                                    width: 80,
								                                    align: 'center'
								                                },
								                                {
								                                    text: 'Total Pag. Errores',
								                                    dataIndex: 'tot_errpag',
								                                    width: 100,
								                                    align: 'center'
								                                },*/
								                                {
								                                    text: 'Devuelto Por:',
								                                    dataIndex: 'usr_dev',
								                                    width: 130,
								                                    align: 'center',
								                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
								                                        //console.log(record);
								                                        var estado = '';
								                                        if(parseInt(record.get('id_dev'))!=0){
								                                        	ser=0;
								                                        	estado = 'DEV:'+record.get('id_dev')+'-USR:'+record.get('usr_dev');
								                                        }

								                                        return estado;
								                                    }
								                                },
								                                {
								                                    text: 'Estado RG',
								                                    dataIndex: 'estado',
								                                    loocked : true,
								                                    width: 70,
								                                    align: 'center',
								                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
								                                        //console.log(record);
								                                        metaData.style = "padding: 0px; margin: 0px";
								                                        var estado = (record.get('estado')=='A')?'check-circle-green-16.png':'check-circle-red.png';
								                                        var qtip = (record.get('estado')=='A')?'Estado del Lote Activo.':'Estado del Lote Inactivo.';

								                                        return global.permisos({
								                                            type: 'link',
								                                            id_menu: ireturn.id_menu,
								                                            icons:[
								                                            	{id_serv: 7, img: estado, qtip: qtip, js: ""}//,
								                                                //{id_serv: 7, img: 'print.png', qtip: 'Imprimir', js: "closing.getPrint("+rowIndex+")"}
								                                            ]
								                                        });
								                                    }
								                                }/*,
																{
													                xtype: 'checkcolumn',
													                header: 'Done',
													                dataIndex: 'done',
													                width: 55,
													                stopSelection: false,
													                headerCheckbox: true,
													                menuDisabled: true/*,
													                listeners: {
													                	 checkchange: 'onCheckcolumnCheckChange'
													                	}*/
													            /*}*/
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
									                                obj.getStore().removeAll();
																	obj.getView().refresh();
									                            },
																beforeselect:function(obj, record, index, eOpts ){

																},
			
														        checkchange: function( node, checked, eOpts ){
														            if(node.hasChildNodes()){
														                node.eachChild(function(childNode){
														                    childNode.set('checked', checked);
														                });
														            }
														        }
														    



									                        }
									                    }
													]
												},
												{
													region:'east',
													title:'Preparar Devolución',
													padding:'5px 5px 5px 0px',
													border:true,
													width:350,
													layout:'border',
													items:[
														{
															region:'south',
															bodyStyle: 'background: transparent',
		                                    				padding:'5px 5px 1px 5px',
															//layout:'fit',
															height:375,
															border:false,
															bbar:[
																{
											                        xtype:'button',
											                        id:ireturn.id+'-btn-nuevo-devolucion',
											                        //disabled:true,
											                        scale: 'large',
											                        flex:1,
											                        //iconAlign: 'top',
											                        //disabled:true,
											                        //width:'50%',
						                                            //anchor:'50%',
											                        text: 'Nuevo',
											                        icon: '/images/icon/if_General_Office_01_2530843.png',
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
											                            	ireturn.setNuevaDevolucion();
											                            }
											                        }
											                    },
																{
											                        xtype:'button',
											                        id:ireturn.id+'-btn-confirmar',
											                        //disabled:true,
											                        scale: 'large',
											                        flex:1,
											                        //iconAlign: 'top',
											                        //disabled:true,
											                        //width:'50%',
						                                            //anchor:'50%',
											                        text: 'Grabar',
											                        icon: '/images/icon/if_General_Office_15_2530780.png',
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
											                            	ireturn.setDevolucion();
											                            }
											                        }
											                    },
											                    {
											                        xtype:'button',
											                        id:ireturn.id+'-btn-cancelar-devolucion',
											                        //disabled:true,
											                        flex:1,
											                        scale: 'large',
											                        //iconAlign: 'top',
											                        //disabled:true,
											                        //width:'50%',
						                                            //anchor:'50%',
											                        text: 'Liberar',
											                        icon: '/images/icon/if_button_cancel_3206.png',
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
											                            	var id_dev =Ext.getCmp(ireturn.id+'-txt-cod-devolucion').getValue();
											                            	ireturn.setClose(id_dev,'C');
											                            }
											                        }
											                    }
															],
															items:[
															    {
				                                                    xtype: 'textfield',	
				                                                    fieldLabel: 'Código',
				                                                    padding:'5px 5px 5px 5px',
				                                                    id:ireturn.id+'-txt-cod-devolucion',
				                                                    labelWidth:85,
				                                                    readOnly:true,
				                                                    labelAlign:'right',
				                                                    value:0,
				                                                    width:'50%',
				                                                    anchor:'50%'
				                                                },
																{
								                                    xtype:'panel',
								                                    border:false,
								                                    bodyStyle: 'background: transparent',
								                                    padding:'5px 5px 5px 5px',
								                                    layout:'column',
								                                    items: [
							                                    		{
																	        xtype: 'datefield',
																	        id:ireturn.id+'-txt-fecha-entrega',
																	        //padding:'5px 5px 5px 5px',
																	        name: 'date1',
																	        labelAlign:'right',
																	        value:new Date(),
					                                                		format: 'Ymd',
																	        labelWidth: 85,
																	        width:185,
																	        fieldLabel: 'Fecha Entrega'
																	    },
																	    {
																	    	xtype: 'timefield',
																		    fieldLabel: 'Hora',
																		    name: 'startTime',
																		    id:ireturn.id+'-txt-hora-entrega',
																		    format: 'H:i',
																		    altFormats:'H:i',
																		    labelAlign:'right',
																		    value:new Date(),
																		    increment: 30,
																		    labelWidth: 40,
																		    width:120,
																		    listeners:{
						                                                        afterrender:function(obj, e){
						                                                        	var timeOut = new Date();
						                                                            obj.setValue(timeOut);
						                                                        },
						                                                        select:function(obj, records, eOpts){
						                                                
						                                                        }
						                                                    }
																		}
																	]
																},
															    {
				                                                    xtype:'combo',
				                                                    fieldLabel: 'Motivo',
				                                                    padding:'5px 5px 5px 5px',
				                                                    id:ireturn.id+'-cbo-motivo',
				                                                    store: store_motivos,
				                                                    queryMode: 'local',
				                                                    triggerAction: 'all',
				                                                    valueField: 'code',
				                                                    displayField: 'name',
				                                                    emptyText: '[Seleccione]',
				                                                    labelAlign:'right',
				                                                    //allowBlank: false,
				                                                    labelWidth: 85,
				                                                    width:'98%',
				                                                    anchor:'98%',
				                                                    //readOnly: true,
				                                                    listeners:{
				                                                        afterrender:function(obj, e){
				                                                            Ext.getCmp(ireturn.id+'-cbo-motivo').setValue('EN');
				                                                        },
				                                                        select:function(obj, records, eOpts){
				                                                
				                                                        }
				                                                    }
				                                                },
				                                                {
				                                                    xtype: 'textfield',	
				                                                    fieldLabel: 'Responsable',
				                                                    padding:'5px 5px 5px 5px',
				                                                    id:ireturn.id+'-txt-responsable',
				                                                    labelWidth:85,
				                                                    //readOnly:true,
				                                                    labelAlign:'right',
				                                                    width:'98%',
				                                                    anchor:'98%'
				                                                },
				                                                {
				                                                    xtype: 'textfield',	
				                                                    fieldLabel: 'Documento',
				                                                    padding:'5px 5px 5px 5px',
				                                                    id:ireturn.id+'-txt-documento',
				                                                    labelWidth:85,
				                                                    //readOnly:true,
				                                                    labelAlign:'right',
				                                                    width:'70%',
				                                                    anchor:'70%'
				                                                },
																{
															        xtype: 'textarea',
															        id:ireturn.id+'-txt-mensaje',
															        padding:'5px 5px 5px 5px',
															        fieldLabel: 'Ingrese el mensaje de Devolución',
															        emptyText: 'Ingrese el mensaje de Devolución',
															        hideLabel: true,
															        height:120,
															        width:'98%',
															        anchor:'98%',
															        name: 'msg'
															    },
															    {
				                                                    xtype:'combo',
				                                                    fieldLabel: 'Estado Devolución',
				                                                    readOnly:true,
				                                                    padding:'5px 5px 5px 5px',
				                                                    id:ireturn.id+'-cbo-estado-devolucion',
				                                                    store: store_estado_devolucion,
				                                                    queryMode: 'local',
				                                                    triggerAction: 'all',
				                                                    valueField: 'code',
				                                                    displayField: 'name',
				                                                    emptyText: '[Seleccione]',
				                                                    labelAlign:'right',
				                                                    //allowBlank: false,
				                                                    labelWidth: 110,
				                                                    width:'98%',
				                                                    anchor:'98%',
				                                                    //readOnly: true,
				                                                    listeners:{
				                                                        afterrender:function(obj, e){
				                                                            Ext.getCmp(ireturn.id+'-cbo-estado-devolucion').setValue('P');
				                                                        },
				                                                        select:function(obj, records, eOpts){
				                                                
				                                                        }
				                                                    }
				                                                }
															]
														},
														{
															region:'center',
															layout:'fit',
															border:false,
															items:[
																{
											                        xtype: 'treepanel',
															        useArrows: true,
															        rootVisible: true,
															        multiSelect: true,
											                        id: ireturn.id + '-grid-devoluciones',
											                        columnLines: true,
											                        store: storeTreePRE,

														            columns: [
															            {
															            	xtype: 'treecolumn',
															            	id: ireturn.id + '-grid-lote_devoluciones-pre',
										                                    text: 'Nombre',
										                                    dataIndex: 'lote_nombre',
										                                    sortable: true,
										                                    flex: 1
										                                },
										                                {
										                                    text: 'Estado Lote',
										                                    dataIndex: 'lot_estado',
										                                    loocked : true,
										                                    width: 80,
										                                    align: 'center',
										                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
										                                        metaData.style = "padding: 0px; margin: 0px";
										                                        var estado = 'document-list-16.png';
										                                        if(parseInt(record.get('nivel'))==1){
											                                        switch(record.get('lot_estado')){
																			        	case 'N':
																			        		estado='';
																			        	break;
																			        	case 'LT':
																			        		estado='baggage_cart_box.png';
																			        	break;
																			        	case 'ES':
																			        		estado='print.png';
																			        	break;
																			        	case 'CO':
																			        		estado='console.png';
																			        	break;
																			        	case 'RE':
																			        		estado='1348695561_stock_mail-send-receive.png';
																			        	break;
																			        	case 'DI':
																			        		estado='approval.png';
																			        	break;
																			        	case 'DE':
																			        		estado='compartir.png';
																			        	break;
																			        }
																		        }
										                                        var qtip = record.get('lot_estado');
										                                        return global.permisos({
										                                            type: 'link',
										                                            id_menu: ireturn.id_menu,
										                                            icons:[
										                                                {id_serv: 7, img: estado, qtip: qtip, js: ""}
										                                            ]
										                                        });
										                                    }
										                                },
										                                {
										                                    text: 'Acción',
										                                    dataIndex: 'lot_estado',
										                                    loocked : true,
										                                    width: 80,
										                                    align: 'center',
										                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
										                                        metaData.style = "padding: 0px; margin: 0px";

										                                        var estado = 'recicle_nov.ico';

										                                        var qtip = 'Agregar Registro a pre devolución';

																				var id_det = 0;
																				if(parseInt(record.get('nivel'))==2){
																					var id_det = record.get('hijo');
																				}
										                                        return global.permisos({
										                                            type: 'link',
										                                            id_menu: ireturn.id_menu,
										                                            icons:[
										                                                {id_serv: 7, img: estado, qtip: qtip, js: "ireturn.setAddPreReturn('D',"+record.get('shi_codigo')+","+record.get('fac_cliente')+","+id_det+","+record.get('id_lote')+")"}
										                                            ]
										                                        });
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
											                                obj.getStore().removeAll();
																			obj.getView().refresh();
											                            },
																		beforeselect:function(obj, record, index, eOpts ){

																		},
					
																        checkchange: function( node, checked, eOpts ){
																            if(node.hasChildNodes()){
																                node.eachChild(function(childNode){
																                    childNode.set('checked', checked);
																                });
																            }
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
											region:'east',
											title:'Devueltos',
											padding:'5px 5px 5px 0px',
											layout:'border',
											width:'35%',
											border:true,
											items:[
												{
													region:'center',
													layout:'fit',
													border:false,
													tbar:[
														{
													        xtype: 'datefield',
													        id:ireturn.id+'-txt-fecha-devolucion',
													        //padding:'5px 5px 5px 5px',
													        name: 'date_dev',
													        labelAlign:'right',
													        value:new Date(),
	                                                		format: 'Y-m-d',
													        labelWidth: 115,
													        width:210,
													        fieldLabel: 'Fecha Registro'
													    },
													    {
									                        xtype:'button',
									                        text: 'Buscar',
									                        icon: '/images/icon/binocular.png',
									                        listeners:{
									                            beforerender: function(obj, opts){
									                            },
									                            click: function(obj, e){	             	
		                               					            ireturn.getDevoluciones();
									                            }
									                        }
									                    }
													],
													items:[
														{
									                        xtype: 'grid',
									                        id: ireturn.id + '-grid-devueltos',
									                        store: store,
									                        columnLines: true,
									                        columns:{
									                            items:[
									                            	{
									                                    text: 'código',
									                                    dataIndex: 'id_dev',
									                                    width: 40
									                                },
									                                {
									                                    text: 'Motivo',
									                                    dataIndex: 'motivo',
									                                    flex: 1,
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        //console.log(record);
									                                        //metaData.style = "padding: 0px; margin: 0px";
									                                        var estado = '';
									                                        var qtip = '';
									                                       switch(record.get('motivo')){
																	        	case 'EN':
																	        		qtip='Entrega de documentos por fin de proceso';
																	        	break;
																	        	case 'PO':
																	        		qtip='Problemas con documentos no legibles';
																	        	break;
																	        	case 'PE':
																	        		qtip='Perdida de documentos';
																	        	break;
																	        	case 'PD':
																	        		qtip='Pedido de Devolución antes de termino del proceso';
																	        	break;
																	        }
									                                        return record.get('motivo') + '-' + qtip;
									                                    }
									                                },
									                                {
									                                    text: 'Fecha',
									                                    dataIndex: 'fecha',
									                                    width: 80
									                                },
									                                {
									                                    text: 'Hora',
									                                    dataIndex: 'hora',
									                                    width: 60
									                                },
									                                {
									                                    text: 'Responsable',
									                                    dataIndex: 'responsable',
									                                    width: 100,
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        return record.get('responsable') + '-' + record.get('documento');
									                                    }
									                                },
									                                {
									                                    text: 'Tot.Lotes',
									                                    dataIndex: 'tot_lotes',
									                                    width: 60
									                                },
									                                {
									                                    text: 'Tot.Folders',
									                                    dataIndex: 'tot_folders',
									                                    width: 70
									                                },
									                                {
									                                    text: 'Estado', 
									                                    dataIndex: 'estado',
									                                    loocked : true,
									                                    width: 50,
									                                    align: 'center',
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        //console.log(record);
									                                        //metaData.style = "padding: 0px; margin: 0px";
									                                        var estado = '';
									                                        var qtip = '';
									                                       switch(record.get('estado')){
																	        	case 'P':
																	        		estado='up_alt.png';
																	        		qtip='Devolución Pendiente';
																	        	break;
																	        	case 'D':
																	        		estado='close_nov.ico';
																	        		qtip='Devuelto';
																	        	break;
																	        	case 'C':
																	        		estado='close.png';
																	        		qtip='Cancelado';
																	        	break;
																	        }
									                                        return global.permisos({
									                                            type: 'link',
									                                            id_menu: ireturn.id_menu,
									                                            icons:[
									                                            	{id_serv: 7, img: estado, qtip: qtip, js: ""}//,
									                                                //{id_serv: 7, img: 'print.png', qtip: 'Imprimir', js: "ireturn.getPrint("+rowIndex+")"}
									                                            ]
									                                        });
									                                    }
									                                },
									                                {
									                                    text: 'Acción', 
									                                    dataIndex: 'estado',
									                                    loocked : true,
									                                    width: 50,
									                                    align: 'center',
									                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
									                                        //console.log(record);
									                                        //metaData.style = "padding: 0px; margin: 0px";
									                                        var estado = '';
									                                        var qtip = '';
									                                       switch(record.get('estado')){
																	        	case 'P':
																	        		estado='up_alt.png';
																	        		qtip='Devolución Pendiente';
																	        	break;
																	        	case 'D':
																	        		estado='close_nov.ico';
																	        		qtip='Devuelto';
																	        	break;
																	        	case 'C':
																	        		estado='close.png';
																	        		qtip='Cancelado';
																	        	break;
																	        }
																	        var serv=0;
																	        if(record.get('estado')=='P')serv=7;
									                                        return global.permisos({
									                                            type: 'link',
									                                            id_menu: ireturn.id_menu,
									                                            icons:[
									                                            	{id_serv: 7, img: '1348695561_stock_mail-send-receive.png', qtip: 'Ver Devolución', js: "ireturn.getView("+rowIndex+")"},
									                                                {id_serv: serv, img: 'padlock-closed.png', qtip: 'Cerrar Devolución', js: "ireturn.setClose("+record.get('id_dev')+",'D')"}
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
						}
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(ireturn.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,ireturn.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(ireturn.id_menu, false);
	                    }
					}

				}).show();
			},
			setAddPreReturn:function(vp_op,shi_codigo,fac_cliente,id_det,id_lote){
				var id_dev =Ext.getCmp(ireturn.id+'-txt-cod-devolucion').getValue();
				var estado = Ext.getCmp(ireturn.id+'-cbo-estado-devolucion').getValue(); 

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(id_dev== null || id_dev==0){
		            global.Msg({msg:"Seleccione un registro de pre devolucion por favor.",icon:2,fn:function(){}});
		            return false;
		        } 
		        if(estado== null || estado=='' || estado!='P'){
		            global.Msg({msg:"El estado de la pre devolucion no esta pendiente por favor seleccione una Devolución pendiente a cerrar o cree una nueva.",icon:2,fn:function(){}});
		            return false;
		        }

                Ext.getCmp(ireturn.id+'-tab').el.mask('Guardando Devolución', 'x-mask-loading');
                Ext.Ajax.request({
                    url: ireturn.url + 'set_pre_return/',
                    params:{
                    	vp_op:vp_op,
                    	vp_shi_codigo:shi_codigo,
                    	vp_fac_cliente:fac_cliente,
                    	vp_id_lote:id_lote,
                    	vp_id_det:id_det,
                    	vp_id_dev:id_dev
                    },
                    success: function(response, options){
                    	Ext.getCmp(ireturn.id+'-tab').el.unmask(); 
                        var res = Ext.JSON.decode(response.responseText);
                        if (res.error == 'OK'){
                            global.Msg({
                                msg: res.msn,
                                icon: 1,
                                buttons: 1,
                                fn: function(btn){
                                	ireturn.getDevoluciones();
                                	ireturn.getReloadPreDevolucion(res.id_dev);
                                	ireturn.getReloadGridlotizer();
                                }
                            });
                        } else{
                            global.Msg({
                                msg: res.msn,
                                icon: 0,
                                buttons: 1,
                                fn: function(btn){
                                    //ireturn.getReloadGridOCR();
                                }
                            });
                        }
                    }
                });
			},
			getView:function(index){
				var record=Ext.getCmp(ireturn.id + '-grid-devueltos').getStore().getAt(index);
				Ext.getCmp(ireturn.id+'-txt-cod-devolucion').setValue(record.data.id_dev);
				Ext.getCmp(ireturn.id+'-txt-fecha-entrega').setValue(record.data.fecha);
				Ext.getCmp(ireturn.id+'-txt-hora-entrega').setValue(record.data.hora);
				Ext.getCmp(ireturn.id+'-cbo-motivo').setValue(record.data.motivo);
				Ext.getCmp(ireturn.id+'-txt-responsable').setValue(record.data.responsable);
				Ext.getCmp(ireturn.id+'-txt-documento').setValue(record.data.documento);
				Ext.getCmp(ireturn.id+'-txt-mensaje').setValue(record.data.mensaje);
				Ext.getCmp(ireturn.id+'-cbo-estado-devolucion').setValue(record.data.estado);
				if(record.data.estado=='P'){
					Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(false);
					Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(false);
				}else{
					Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(true);
					Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(true);
				}
				ireturn.getReloadPreDevolucion(record.data.id_dev);
			},
			getDevoluciones:function(){
				var fecha = Ext.getCmp(ireturn.id+'-txt-fecha-devolucion').getRawValue();
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();

				Ext.getCmp(ireturn.id + '-grid-devueltos').getStore().removeAll();
				Ext.getCmp(ireturn.id + '-grid-devueltos').getStore().loadPage(1,
	                {params: {
	                	vp_shi_codigo:shi_codigo,
	                	vp_fac_cliente:fac_cliente,
	                	vp_id_dev:0,
	                	vp_motivo:'',
	                	vp_fecha:fecha,
	                	vp_estado:''
	                },
	                callback:function(){
	                	 //ireturn.setNuevaDevolucion();
	                }
	            });
			},
			setNuevaDevolucion:function(){
				Ext.getCmp(ireturn.id+'-txt-cod-devolucion').setValue(0);
				var timeOut = new Date();
				Ext.getCmp(ireturn.id+'-txt-fecha-entrega').setValue(timeOut);
				Ext.getCmp(ireturn.id+'-txt-hora-entrega').setValue(timeOut);
				Ext.getCmp(ireturn.id+'-cbo-motivo').setValue('EN');
				Ext.getCmp(ireturn.id+'-txt-responsable').setValue('');
				Ext.getCmp(ireturn.id+'-txt-documento').setValue('');
				Ext.getCmp(ireturn.id+'-txt-mensaje').setValue('');
				Ext.getCmp(ireturn.id+'-cbo-estado-devolucion').setValue('P');
				Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(true);
				Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(false);
				Ext.getCmp(ireturn.id + '-grid-devoluciones').getStore().removeAll();
				Ext.getCmp(ireturn.id + '-grid-devoluciones').getView().refresh();
			},
			setClose:function(id_dev,op){
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
				global.Msg({
                    msg: (op=='D')?'¿Está seguro de cerrar la Devolución?, recuerde que no será posible volver al estado anterior.':'¿Está seguro de liberar el registro previo de Devolución?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(true);
			                Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(true);
	                        Ext.getCmp(ireturn.id+'-tab').el.mask('Guardando Devolución', 'x-mask-loading');
	                        Ext.Ajax.request({
			                    url: ireturn.url + 'set_return/',
			                    params:{
			                    	vp_op:op,
			                    	vp_shi_codigo:shi_codigo,
			                    	vp_fac_cliente:fac_cliente,
			                    	vp_id_dev:id_dev,
						            vp_motivo:'',
						            vp_fecha:'',
						            vp_hora:'',
						            vp_responsable:'',
						            vp_documento:'',
						            vp_mensaje:''
			                    },
			                    success: function(response, options){
			                    	Ext.getCmp(ireturn.id+'-tab').el.unmask(); 
			                        var res = Ext.JSON.decode(response.responseText);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	//refrescar devoluciones
			                                	ireturn.setNuevaDevolucion();
			                                	ireturn.getDevoluciones();
			                                	ireturn.getReloadGridlotizer();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    //ireturn.getReloadGridOCR();
			                                	Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(false);
			                                	Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(false);
			                                }
			                            });
			                        }
			                    }
			                });
						}
		            }
                });
			},
			setDevolucion:function(){
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
				var id_dev =Ext.getCmp(ireturn.id+'-txt-cod-devolucion').getValue();
				var fecha = Ext.getCmp(ireturn.id+'-txt-fecha-entrega').getRawValue();
				var hora = Ext.getCmp(ireturn.id+'-txt-hora-entrega').getRawValue();
				var motivo = Ext.getCmp(ireturn.id+'-cbo-motivo').getValue();
				var responsable = Ext.getCmp(ireturn.id+'-txt-responsable').getValue();
				var documento = Ext.getCmp(ireturn.id+'-txt-documento').getValue();
				var mensaje = Ext.getCmp(ireturn.id+'-txt-mensaje').getValue();
				var estado = Ext.getCmp(ireturn.id+'-cbo-estado-devolucion').getValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }

		    	if(fecha== null || fecha==''){
		            global.Msg({msg:"Seleccione una fecha por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(hora== null || hora==''){
		            global.Msg({msg:"Seleccione la hora por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(motivo== null || motivo==''){
		            global.Msg({msg:"Seleccione un motivo.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(responsable== null || responsable==''){
		            global.Msg({msg:"Ingrese nombre de responsable o entidad.",icon:2,fn:function(){}});
		            return false;
		        }


				global.Msg({
                    msg: (id_dev!=0)?'¿Está seguro de actualizar la Devolución?':'¿Está seguro de registrar la Devolución?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
                    		Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(true);
			                Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(true);
	                        Ext.getCmp(ireturn.id+'-tab').el.mask('Guardando Devolución', 'x-mask-loading');
	                        Ext.Ajax.request({
			                    url: ireturn.url + 'set_return/',
			                    params:{
			                    	vp_op:(id_dev!=0)?'U':'I',
			                    	vp_shi_codigo:shi_codigo,
			                    	vp_fac_cliente:fac_cliente,
			                    	vp_id_dev:id_dev,
						            vp_motivo:motivo,
						            vp_fecha:fecha,
						            vp_hora:hora,
						            vp_responsable:responsable,
						            vp_documento:documento,
						            vp_mensaje:mensaje
			                    },
			                    success: function(response, options){
			                    	Ext.getCmp(ireturn.id+'-tab').el.unmask(); 
			                        var res = Ext.JSON.decode(response.responseText);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	//refrescar devoluciones
			                                	Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(false);
		                                		Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(false);
		                                		Ext.getCmp(ireturn.id+'-txt-cod-devolucion').setValue(res.id_dev);
			                                	//Ext.getCmp(ireturn.id+'-cbo-estado-devolucion').setValue('D');
			                                	ireturn.getDevoluciones();
			                                	ireturn.getReloadGridlotizer();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    //ireturn.getReloadGridOCR();
			                                    if(id_dev!=0){
			                                		Ext.getCmp(ireturn.id+'-btn-cancelar-devolucion').setDisabled(false);
			                                	}
			                                	Ext.getCmp(ireturn.id+'-btn-confirmar').setDisabled(false);
			                                }
			                            });
			                        }
			                    }
			                });
						}
		            }
                });
				
			},
			setEditLote:function(index,op){
				var rec = Ext.getCmp(ireturn.id + '-grid').getStore().getAt(index);
				ireturn.id_lote=rec.data.id_lote;
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
				if(rec.data.shi_codigo!=shi_codigo){
					Ext.getCmp(ireturn.id+'-cbx-cliente').setValue(rec.data.shi_codigo);
					Ext.getCmp(ireturn.id+'-cbx-contrato').setValue('');
					ireturn.getContratos(rec.data.shi_codigo);
				}
				Ext.getCmp(ireturn.id+'-cbx-contrato').setValue(rec.data.fac_cliente);
				ireturn.shi_codigo=rec.data.shi_codigo;
				ireturn.fac_cliente=rec.data.fac_cliente;

				ireturn.opcion=op;
				if(op!='D'){
					Ext.getCmp(ireturn.id+'-txt-nombre').setValue(rec.data.nombre);
					Ext.getCmp(ireturn.id+'-txt-descripcion').setValue(rec.data.descripcion);
				  	Ext.getCmp(ireturn.id+'-txt-estado').setValue(rec.data.estado);
				  	Ext.getCmp(ireturn.id+'-txt-tot_folder').setValue(rec.data.tot_folder);


				  	Ext.getCmp(ireturn.id+'-txt-nombre').focus(true);

				}else{
					ireturn.set_lotizer(2,'¿Está seguro de Desactivar?');
				}
			},
			set_lotizer_clear:function(){
			  	ireturn.id_lote=0;
			  	ireturn.shi_codigo=0;
				ireturn.fac_cliente=0;
				ireturn.opcion='I';
				Ext.getCmp(ireturn.id+'-cbx-cliente').focus(true);
			},
			setValidaLote:function(){
				if(ireturn.opcion=='I' || ireturn.opcion=='U'){
					var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
					if(shi_codigo== null || shi_codigo==''){
			            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        ireturn.shi_codigo=shi_codigo;
					var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
					if(fac_cliente== null || fac_cliente==''){
			            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        ireturn.fac_cliente=fac_cliente;
					var nombre = Ext.getCmp(ireturn.id+'-txt-nombre').getValue();
					if(nombre== null || nombre==''){
			            global.Msg({msg:"Ingrese un nombre por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			        var estado = Ext.getCmp(ireturn.id+'-txt-estado').getValue();
			        if(estado== null || estado==''){
			            global.Msg({msg:"Ingrese un estado por favor.",icon:2,fn:function(){}});
			            return false; 
			        }
				  	var total = Ext.getCmp(ireturn.id+'-txt-tot_folder').getValue();
				  	if(total== null || total==0 || total==''){
			            global.Msg({msg:"Ingrese el total de folderes por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			    }
		        return true;
			},
			set_lotizer:function(ico,msn){
				if(!ireturn.setValidaLote())return;
				global.Msg({
                    msg: msn,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(ireturn.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
	                        Ext.Ajax.request({
								url: ireturn.url + 'set_lotizer/',
								params:{
									vp_op: ireturn.opcion,
									vp_shi_codigo:ireturn.shi_codigo,
									vp_fac_cliente:ireturn.fac_cliente,
			                        vp_id_lote:ireturn.id_lote,
			                        vp_nombre:Ext.getCmp(ireturn.id+'-txt-nombre').getValue(),
			                        vp_descripcion:Ext.getCmp(ireturn.id+'-txt-descripcion').getValue(),
			                        vp_tipdoc:Ext.getCmp(ireturn.id+'-txt-tipdoc').getValue(),
			                        vp_lote_fecha:Ext.getCmp(ireturn.id+'-txt-fecha').getValue(),
			                        vp_ctdad:Ext.getCmp(ireturn.id+'-txt-tot_folder').getValue(),
			                        vp_estado:Ext.getCmp(ireturn.id+'-txt-estado').getValue()
								},
								success:function(response,options){
									var res = Ext.decode(response.responseText);
									Ext.getCmp(ireturn.id+'-tab').el.unmask();
									global.Msg({
		                                msg: res.msn,
		                                icon: parseInt(res.error),
		                                buttons: 1,
		                                fn: function(btn){
		                                    if(parseInt(res.error)==1){
		                                    	ireturn.getReloadGridlotizer();
		                                    	ireturn.set_lotizer_clear();
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
				Ext.getCmp(ireturn.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(ireturn.id+'-cbx-contrato').getStore().loadPage(1,
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){

	                }
	            });
			},
			getReloadGridlotizer:function(){
				ireturn.set_lotizer_clear();
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(ireturn.id+'-txt-lote').getValue();
				var name = Ext.getCmp(ireturn.id+'-txt-lotizer').getValue();
				var estado = Ext.getCmp(ireturn.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(ireturn.id+'-txt-fecha-filtro').getRawValue();

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
		        Ext.getCmp(ireturn.id + '-grid').getStore().removeAll();
				Ext.getCmp(ireturn.id + '-grid').getView().refresh();
		        ireturn.paramsStore={vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'DI',vp_name:name,fecha:fecha,vp_estado:estado};
				Ext.getCmp(ireturn.id + '-grid').getStore().loadPage(1,
	                {params:ireturn.paramsStore,
	                callback:function(){

	                }
	            });
			},
			getReloadPreDevolucion:function(id_dev){
				//Ext.getCmp(ireturn.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
				var shi_codigo = Ext.getCmp(ireturn.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(ireturn.id+'-cbx-contrato').getValue();
				Ext.getCmp(ireturn.id + '-grid-devoluciones').getStore().removeAll();
				Ext.getCmp(ireturn.id + '-grid-devoluciones').getView().refresh();

				//Ext.getCmp(ireturn.id + '-grid-devoluciones').getStore().baseParams = {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_id_dev:id_dev};
				ireturn.paramsStorePRE={vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_id_dev:id_dev};
				Ext.getCmp(ireturn.id + '-grid-devoluciones').getStore().loadPage(1,
	                {params: ireturn.paramsStorePRE,
	                callback:function(){
	                	//Ext.getCmp(ireturn.id+'-tab').el.unmask();
	                	//ireturn.getReloadGridlotizer();
	                }
	            });
			},
			setNuevo:function(){

				Ext.getCmp(ireturn.id+'-txt-nombre').setValue('');
				Ext.getCmp(ireturn.id+'-txt-nombre').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-tipdoc').setValue('');
				Ext.getCmp(ireturn.id+'-txt-tipdoc').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-fecha').setValue('');
				Ext.getCmp(ireturn.id+'-txt-fecha').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-estado').setValue('');
				Ext.getCmp(ireturn.id+'-txt-estado').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-tot_folder').setValue('');
				Ext.getCmp(ireturn.id+'-txt-tot_folder').setReadOnly(false);
				Ext.getCmp(ireturn.id+'-txt-nombre').focus();
			},

			set_return:function(ico,msn,storeReturn){
				
				global.Msg({
                    msg: msn,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){

						    storeReturn.each(function(record,index) {
									        ireturn.nombre = record.data.nombre;
									        ireturn.id_lote = record.data.id_lote;
									        ireturn.id_det = record.data.id_det;

					                        Ext.getCmp(ireturn.id+'-tab').el.mask('Cargando…', 'x-mask-loading');
					                        Ext.Ajax.request({
												url: ireturn.url + 'set_return/',
												params:{
							                        vp_nombre:ireturn.nombre,
							                        vp_id_lote:ireturn.id_lote,
							                        vp_id_det:ireturn.id_det
												},
												success:function(response,options){
													var res = Ext.decode(response.responseText);
													Ext.getCmp(ireturn.id+'-tab').el.unmask();
													global.Msg({
						                                msg: res.msn,
						                                icon: parseInt(res.error),
						                                buttons: 1,
						                                fn: function(btn){
						                                    if(parseInt(res.error)==1){
						                                    	if (ireturn.opcion == 'U' || ireturn.opcion == 'I') {

						                                    	}
						                                    	ireturn.getReloadGridlotizer();
						                                    	ireturn.set_lotizer_clear();
						                                    }
						                                }
						                            });
								    			}

							});



				    		});
				    	}
		            }
                });
			},

			onCheckcolumnCheckChange: function(checkcolumn, rowIndex, checked, eOpts) {
			    var view = this.getView();
			    var item = this.getStore().data.items[rowIndex];
			    var columnName = checkcolumn.dataIndex;

			    // User unchecked a row: refresh the view
			    if(!checked){
			        view.refresh();
			        return;
			    }

			    // User checked a row: unselect all parents
			    var parentNode = item.parentNode;
			    while(typeof parentNode != 'undefined' && parentNode !== null && !parentNode.data.root){
			        parentNode.set(columnName, false);
			        parentNode = parentNode.parentNode;
			    }

			    // Then uncheck all childs (recusif)
			    (function doChild(children){
			        if(typeof children == 'undefined' || children === null || children.length <= 0)
			            return;

			        for(var i=0; i<children.length; i++){
			            children[i].set(columnName, false);
			            doChild(children[i].childNodes);    // <= recursivity
			        }
			    })(item.childNodes);

			    view.refresh();
			}			
			,
			getFormMant:function(arrDataCollection){

			Ext.define('TestModel', {
			    extend: 'Ext.data.Model',
		        fields: [
		            { name: "nombre", type: "string" },
		            { name: "id_lote", type: "int"  },
		            { name: "id_det", type: "int"  },
		        ]
			});

			var store_devolver = Ext.create('Ext.data.ArrayStore', {
		        autoLoad: true,
		        model:TestModel,
		        data: arrDataCollection
		    });

				Ext.create('Ext.window.Window',{
	                id:ireturn.id+'-win-form',
	                plain: true,
	                title:'Devolución',
	                icon: '/images/icon/if_General_Office_36_2530817.png',
	                height: 200,
	                width: 450,
	                resizable:false,
	                modal: true,
	                border:false,
	                closable:true,
	                padding:20,
	                items:[
	                	{
	                        xtype: 'grid',
	                        id:ireturn.id+'-grid-return-form',
	                        store:store_devolver,
	                        columnLines: true,
	                        columns:{
	                            items:[
	                                {
	                                    text: 'Nombre',
	                                    dataIndex: 'nombre',
	                                    flex: 1
	                                },
	                                	                                {
	                                    text: 'id_lote',
	                                    dataIndex: 'id_lote',
	                                    flex: 1
	                                },
	                                	                                {
	                                    text: 'id_det',
	                                    dataIndex: 'id_det',
	                                    flex: 1
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
			                            }
			                        }



	                    }
	                ],
	                bbar:[       
	                    '->',
	                    '-',
	                    {
	                        xtype:'button',
	                        text: 'Devolver',
	                        icon: '/images/icon/save.png',
	                        listeners:{
	                            beforerender: function(obj, opts){
								},
	                            click: function(obj, e){

									Ext.getCmp(ireturn.id+'-win-form').el.mask('Cargando…', 'x-mask-loading');
									ireturn.set_return(3,'¿Está seguro de devolver?',store_devolver);
									Ext.getCmp(ireturn.id+'-win-form').close();	

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
	                                Ext.getCmp(ireturn.id+'-win-form').close();
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
			}

		}
		Ext.onReady(ireturn.init,ireturn);
	}else{
		tab.setActiveTab(ireturn.id+'-tab');
	}
</script>