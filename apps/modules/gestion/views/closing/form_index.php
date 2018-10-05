<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('closing-tab')){
		var closing = {
			id:'closing',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/closing/',
			opcion:'I',
			id_lote:0,
			shi_codigo:0,
			fac_cliente:0,
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
	                    {name: 'nivel', type: 'string'}
				    ]
				});
				var storeTree = new Ext.data.TreeStore({
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: closing.url+'get_list_lotizer/'//,
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
	                 		Ext.getCmp(closing.id + '-grid-closing').doLayout();
	                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(closing.id + '-grid-closing').collapseAll();
		                    Ext.getCmp(closing.id + '-grid-closing').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                    });
		                    Ext.getCmp(closing.id + '-grid-closing').expandAll();
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
	                    url: closing.url+'get_list_shipper/',
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
	                    url: closing.url+'get_list_contratos/',
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
				    ['databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']
				];
				var store_estados = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'estado',
			        autoLoad: false,
			        data: myData,
			        fields: ['clase_box1', 'clase_box2', 'clase_box3', 'clase_box4', 'clase_box5', 'clase_box6']
			    });

			    var myDataIMAGEN = [
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color'],
				    ['databox_interno_color']
				];
				var store_imagen = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'imagen',
			        autoLoad: false,
			        data: myDataIMAGEN,
			        fields: ['clase_box1']
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

				var panel = Ext.create('Ext.form.Panel',{
					id:closing.id+'-form',
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
				var imageTplPointer = new Ext.XTemplate(
		            '<tpl for=".">',
		                '<div class="databox_principal" >',
		                    '<div class="{clase_box1}">',
		                    	'<p><img src="/images/icon/baggage_cart_box.png"/></p>',
		                        '<hr></hr>',
		                        '<p>Lotizado</p>',
		                    '</div>',
		                    '<div class="{clase_box2}">',
		                    	'<p><img src="/images/icon/if_General_Office_21_2530827.png"/></p>',
		                        '<hr></hr>',
		                        '<p>Escaneo</p>',
		                    '</div>',
		                    '<div class="{clase_box3}">',
		                    	'<p><img src="/images/icon/if_General_Office_03_2530841.png"/></p>',
		                        '<hr></hr>',
		                        '<p>Control</p>',
		                    '</div>',
		                    '<div class="{clase_box4}">',
		                    	'<p><img src="/images/icon/if_General_Office_63_2530796.png"/></p>',
		                        '<hr></hr>',
		                        '<p>Reproceso</p>',
		                    '</div>',
		                    '<div class="{clase_box5}">',
		                    	'<p><img src="/images/menu/if_Logo_Design_1562698.png"/></p>',
		                        '<hr></hr>',
		                        '<p>Digitalizado</p>',
		                    '</div>',
		                    '<div class="{clase_box6}">',
		                    	'<p><img src="/images/icon/if_General_Office_36_2530817.png"/></p>',
		                        '<hr></hr>',
		                        '<p>Devuelto</p>',
		                    '</div>',
		                '</div>',
		            '</tpl>'
		        );
				tab.add({
					id:closing.id+'-tab',
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
			                                                    id:closing.id+'-cbx-cliente',
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
			                                                        	Ext.getCmp(closing.id+'-cbx-contrato').setValue('');
			                                                			closing.getContratos(records.get('shi_codigo'));
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
			                                                    id:closing.id+'-cbx-contrato',
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
		                        },
		                        {
		                            region:'center',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'DC',
		                            title: 'Busqueda de Documentos',
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
		                                                    id:closing.id+'-txt-lote',
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
		                                            width:300,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre Lote',
		                                                    id:closing.id+'-txt-closing',
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
			                                                id:closing.id+'-txt-fecha-filtro',
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
			                                                    id:closing.id+'-txt-estado-filter',
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
			                                                            Ext.getCmp(closing.id+'-txt-estado-filter').setValue('A');
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
		                               					            closing.getReloadGridclosing();
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
							                        id: closing.id + '-grid-closing',
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
											            	xtype: 'treecolumn',
						                                    text: 'Nombre',
						                                    dataIndex: 'lote_nombre',
						                                    sortable: true,
						                                    width:250,
						                                },
						                                {
						                                    text: 'Descripción',
						                                    dataIndex: 'descripcion',
						                                    flex: 2
						                                },
						                                {
						                                    text: 'Estado Lote',
						                                    dataIndex: 'lot_estado',
						                                    loocked : true,
						                                    width: 100,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        metaData.style = "padding: 0px; margin: 0px";
						                                        var estado = 'basket_put.png';
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
															        	case 'FI':
															        		estado='approval.png';
															        	break;
															        	case 'DE':
															        		estado='compartir.png';
															        	break;
															        }
														        }
						                                        var qtip = record.get('descripcion');
						                                        return global.permisos({
						                                            type: 'link',
						                                            id_menu: closing.id_menu,
						                                            icons:[
						                                                {id_serv: 5, img: estado, qtip: qtip, js: ""}
						                                            ]
						                                        });
						                                    }
						                                },
						                                {
						                                    text: 'Fecha y Hora',
						                                    dataIndex: 'fecha',
						                                    width: 180,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Total Folder',
						                                    dataIndex: 'tot_folder',
						                                    width: 80,
						                                    align: 'center'
						                                },
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
						                                },
						                                {
						                                    text: 'User',
						                                    dataIndex: 'usr_update',
						                                    width: 100,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Estado',
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
						                                            id_menu: closing.id_menu,
						                                            icons:[
						                                            	{id_serv: 5, img: estado, qtip: qtip, js: ""},
						                                                {id_serv: 5, img: 'print.png', qtip: 'Imprimir', js: "closing.getPrint("+rowIndex+")"},
						                                                {id_serv: 5, img: 'download_.png', qtip: 'Descargar Zip', js: "closing.getZip("+rowIndex+")"}
						                                            ]
						                                        });
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
							                                //closing.getImagen('default.png');
							                                
							                            },
														beforeselect:function(obj, record, index, eOpts ){
															closing.getStatusPanel(record.get('lot_estado'));

															document.getElementById('imagen-closing').innerHTML='<img src="'+record.get('path')+record.get('img')+'" width="100%" height="100%"/>'

															//console.log(record);
															/*closing.opcion='U';*/
															/*closing.id_lote=record.get('id_lote');
															/*closing.getImagen(record.get('imagen'));*/
															/*Ext.getCmp(closing.id+'-txt-nombre').setValue(record.get('nombre'));
															Ext.getCmp(closing.id+'-txt-tipdoc').setValue(record.get('tipdoc'));
															Ext.getCmp(closing.id+'-txt-fecha').setValue(record.get('fecha'));
															Ext.getCmp(closing.id+'-txt-estado').setValue(record.get('estado'));
															Ext.getCmp(closing.id+'-txt-tot_folder').setValue(record.get('tot_folder'));

															Ext.getCmp(closing.id+'-txt-nombre').setReadOnly(true);
															Ext.getCmp(closing.id+'-txt-tipdoc').setReadOnly(true);
															Ext.getCmp(closing.id+'-txt-fecha').setReadOnly(true);
															Ext.getCmp(closing.id+'-txt-estado').setReadOnly(true);
															Ext.getCmp(closing.id+'-txt-tot_folder').setReadOnly(true);


															var botonTxt = Ext.getCmp('boton').getText();
															if (botonTxt == 'Guardar' || botonTxt == 'Update') {
																Ext.getCmp('boton').setText('Editar');
																Ext.getCmp('boton').setIcon('/images/icon/editar.png');
															}*/

															//closing.getReloadGridclosing2(closing.id_lote);

														}
							                        }
							                    }
							                ]
							            }
									]
									
								},
								{
									region:'east',
									title:'Imagen',
									//width:'100%',
									width:500,
									html: '<div id="imagen-closing" style="width:100%; height:"100%;overflow: none;" ><img src="/plantillas/Document-Scanning-Indexing-Services-min.jpg" width="100%" height="100%"/></div>'
								}
							]
						}
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(closing.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                    	//closing.getReloadGridclosing('');
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,closing.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(closing.id_menu, false);
	                    }
					}

				}).show();
			},
			getPrint:function(index){
				var record=Ext.getCmp(closing.id + '-grid-closing').getStore().getAt(index);
				var hijo=record.data.hijo;
			    var padre=record.data.padre;
			    var lote =record.data.id_lote;
			    var nivel=record.data.nivel;
			    var shi_codigo=record.data.shi_codigo;

			    var id_pag=0;
			    var id_det=0;

			    if(nivel!=1){
			    	if(nivel==2){
			    		id_det=hijo;
			    	}else{
			    		id_pag=hijo;
			    		id_det=padre;
			    	}
			    }

				window.open(closing.url+'get_print/?vp_shi_codigo='+shi_codigo+'&vp_id_lote='+lote+'&vp_id_det='+id_det+'&vp_id_pag='+id_pag, '_blank');
			},
			getZip:function(index){
				var record=Ext.getCmp(closing.id + '-grid-closing').getStore().getAt(index);
				var hijo=record.data.hijo;
			    var padre=record.data.padre;
			    var lote =record.data.id_lote;
			    var nivel=record.data.nivel;
			    var shi_codigo=record.data.shi_codigo;

			    var id_pag=0;
			    var id_det=0;

			    if(nivel!=1){
			    	if(nivel==2){
			    		id_det=hijo;
			    	}else{
			    		id_pag=hijo;
			    		id_det=padre;
			    	}
			    }
				window.open(closing.url+'get_zip/?vp_shi_codigo='+shi_codigo+'&vp_id_lote='+lote+'&vp_id_det='+id_det+'&vp_id_pag='+id_pag, '_blank');
			},
			getStatusPanel: function(ES) {
		        /*Ext.getCmp(closing.id+'-check-status').getStore().removeAll();
		        switch(ES){
		        	case 'N':
		        		Ext.getCmp(closing.id+'-check-status').getStore().loadData([['databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'LT':
		        		Ext.getCmp(closing.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'ES':
		        		Ext.getCmp(closing.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'CO':
		        		Ext.getCmp(closing.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'RE':
		        		Ext.getCmp(closing.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color_red','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'DI':
		        		Ext.getCmp(closing.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color_green','databox_interno_color']]);
		        	break;
		        	case 'DE':
		        		Ext.getCmp(closing.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color_green','databox_interno_color_blue']]);
		        	break;
		        }*/
		    },
			getImagen:function(param){
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/images/icon/'+param}});///closing/
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(closing.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(closing.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(closing.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridclosing:function(){
				//Ext.getCmp(closing.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				closing.getStatusPanel('N');
				var shi_codigo = Ext.getCmp(closing.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(closing.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(closing.id+'-txt-lote').getValue();
				var name = Ext.getCmp(closing.id+'-txt-closing').getValue();
				var estado = Ext.getCmp(closing.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(closing.id+'-txt-fecha-filtro').getRawValue();

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
		        //Ext.getCmp(closing.id + '-grid-closing').getStore().removeAll();
		        Ext.getCmp(closing.id + '-grid-closing').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'DI',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(closing.id+'-form').el.unmask();
	                }
	            });
			}

		}
		Ext.onReady(closing.init,closing);
	}else{
		tab.setActiveTab(closing.id+'-tab');
	}
</script>