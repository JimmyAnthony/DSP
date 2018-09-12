<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('scanning-tab')){
		var scanning = {
			id:'scanning',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/scanning/',
			opcion:'I',
			runner: new Ext.util.TaskRunner(),
			work:false,
			shi_codigo:0,
			id_det:0,
			id_lote:0,
			init:function(){
				Ext.tip.QuickTipManager.init();

				scanning.task = scanning.runner.newTask({
                    run: function(){
                        scanning.getScanning();
                    },
                    interval: (1000 * 30)
                });

                scanning.task.start();

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
	                    url: scanning.url+'get_list_lotizer/'//,
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
	                 		Ext.getCmp(scanning.id + '-grid').doLayout();
	                 		//Ext.getCmp(scanning.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(scanning.id + '-grid').collapseAll();
		                    Ext.getCmp(scanning.id + '-grid').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
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
                    url: scanning.url+'get_list/?vp_cod_lote=0',
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
                    url: scanning.url+'get_list_shipper/',
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
                    url: scanning.url+'get_list_contratos/',
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
					id:scanning.id+'-form',
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
							width:350,
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
		                            region:'north',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'BE',
		                            title: 'Busqueda de Lotes a Escanear',
		                            legend: 'Seleccione el Lote Registrado',
		                            width:350,
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
			                                   		width: 300,border:false,
			                                    	padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                              {
				                                            xtype:'combo',
				                                            fieldLabel: 'Cliente',
				                                            id:scanning.id+'-cbx-cliente',
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
				                                                	Ext.getCmp(scanning.id+'-cbx-contrato').setValue('');
				                                        			scanning.getContratos(records.get('shi_codigo'));
				                                                }
				                                            }
				                                        }
			                                 		]
			                                    },
			                                    {
			                                   		width: 300,border:false,
			                                    	padding:'10px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Contrato',
			                                                    id:scanning.id+'-cbx-contrato',
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
		                                            width:300,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'N° Lote',
		                                                    id:scanning.id+'-txt-lote',
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
		                                                    fieldLabel: 'Nombre',
		                                                    id:scanning.id+'-txt-scanning',
		                                                    labelWidth: 50,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
			                                        width: 300,border:false,
			                                        padding:'0px 2px 5px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                    	layout:'column',
			                                        items:[
			                                            {
			                                                xtype:'datefield',
			                                                id:scanning.id+'-txt-fecha-filtro',
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
									                            	var name = Ext.getCmp(scanning.id+'-txt-scanning').getValue();
		                               					            scanning.getReloadGridscanning(name);
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
							                        id: scanning.id + '-grid',
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
						                                    renderer: scanning.renderTip,
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
						                                            id_menu: scanning.id_menu,
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
						                                }/*,
						                                {
						                                    text: 'Total Pag. Errores',
						                                    dataIndex: 'tot_errpag',
						                                    width: 100,
						                                    align: 'center'
						                                },
						                                {
						                                    text: 'Editar',
						                                    dataIndex: 'estado',
						                                    //loocked : true,
						                                    width: 50,
						                                    align: 'center',
						                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
						                                        //console.log(record);
						                                        if(parseInt(record.get('nivel')) == 1){
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: scanning.id_menu,
							                                            icons:[
							                                                {id_serv: 1, img: 'ico_editar.gif', qtip: 'Click para Editar Lote.', js: "scanning.setEditLote("+rowIndex+",'U')"},
							                                                {id_serv: 1, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "scanning.setEditLote("+rowIndex+",'D')"}
							                                            ]
							                                        });
							                                    }else{
						                                        	return '';
						                                        }
						                                    }
						                                }*/
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
							                                //scanning.getImagen('default.png');
							                                
							                            },
														beforeselect:function(obj, record, index, eOpts ){
															scanning.shi_codigo=record.get('shi_codigo');
															scanning.id_det=record.get('id_det');
															scanning.id_lote=record.get('id_lote');
														}
							                        }
							                    }
											]
										},
										{
											region:'south',
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
											layout:'fit',
											border:true,
											padding:'5px 5px 5px 5px',
											items:[
												{
							                        xtype: 'grid',
							                        id: scanning.id + '-grid-paginas',
							                        store: store,
							                        columnLines: true,
							                        columns:{
							                            items:[
							                                {
							                                    text: 'Páginas',
							                                    dataIndex: 'lote',
							                                    width: 50
							                                },
							                                {
							                                    text: 'Descripción',
							                                    dataIndex: 'descripcion',
							                                    flex: 1
							                                },
							                                {
							                                    text: 'Flag',
							                                    dataIndex: 'flag',
							                                    width: 50
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
								},
								{
									region:'center',
									border:false,
									layout:'border',
									items:[
										{
											region:'north',
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
											id: scanning.id+'-panel_img',
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
					id:scanning.id+'-tab',
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
	                        global.state_item_menu(scanning.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,scanning.id_menu);
	                        scanning.getImg_tiff('escaneado');
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(scanning.id_menu, false);
	                    }
					}

				}).show();
			},
			getScanning:function(){
				if(!scanning.work){
					if(parseInt(scanning.shi_codigo)==0){ 
						return false;
					}
					if(parseInt(scanning.id_det)==0){
						return false;
					}
					if(parseInt(scanning.id_lote)==0){
						return false;
					}
					console.log(scanning.shi_codigo+'-'+scanning.id_det+'-'+scanning.id_lote);
					scanning.work=!scanning.work;

					Ext.Ajax.request({
	                    url: scanning.url+'/get_scanner_file/',
	                    params:{
	                    	vp_op:'I',
	                    	vp_shi_codigo:scanning.shi_codigo,
	                    	vp_id_pag:0,
	                    	vp_id_det:scanning.id_det,
	                    	vp_id_lote:scanning.id_lote,
	                    	path:'C:/twain/',
	                    	vp_estado:'A'
	                    },
	                    success: function(response, options){
	                        //var res = Ext.JSON.decode(response.responseText);
	                        scanning.work=!scanning.work;
	                        console.log(response);
	                        /*if (parseInt(res.time) == 0 ){
	                            scanning.task.stop();
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
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/scanning/'+param}});
			},
			setscanning:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(scanning.id+'-form').el.mask('Cargando…', 'x-mask-loading');

						Ext.getCmp(scanning.id+'-form-info').submit({
		                    url: scanning.url + 'setRegisterCampana/',
		                    params:{
		                        vp_op: scanning.opcion,
		                        vp_shi_codigo:scanning.cod_cam,
		                        vp_shi_nombre:Ext.getCmp(scanning.id+'-txt-nombre').getValue(),
		                        vp_shi_descripcion:Ext.getCmp(scanning.id+'-txt-descripcion').getValue(),
		                        vp_fec_ingreso:Ext.getCmp(scanning.id+'-date-re').getRawValue(),
		                        vp_estado:Ext.getCmp(scanning.id+'-cmb-estado').getValue()
		                    },
		                    success: function( fp, o ){
		                    	//console.log(o);
		                        var res = o.result;
		                        Ext.getCmp(scanning.id+'-form').el.unmask();
		                        //console.log(res);
		                        if (parseInt(res.error) == 0){
		                            global.Msg({
		                                msg: res.data,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
		                                    scanning.getReloadGridscanning('');
		                                    scanning.setNuevo();
		                                }
		                            });
		                        } else{
		                            global.Msg({
		                                msg: 'Ocurrio un error intentalo nuevamente.',
		                                icon: 0,
		                                buttons: 1,
		                                fn: function(btn){
		                                    scanning.getReloadGridscanning('');
		                                    scanning.setNuevo();
		                                }
		                            });
		                        }
		                    }
		                });
		            }
                });
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(scanning.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(scanning.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(scanning.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridscanning:function(name){
				//scanning.set_scanning_clear();
				//Ext.getCmp(scanning.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				var shi_codigo = Ext.getCmp(scanning.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(scanning.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(scanning.id+'-txt-lote').getValue();
				var name = Ext.getCmp(scanning.id+'-txt-scanning').getValue();
				var estado = 'A';//Ext.getCmp(scanning.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(scanning.id+'-txt-fecha-filtro').getRawValue();

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
				Ext.getCmp(scanning.id + '-grid').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'LT',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(scanning.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				scanning.shi_codigo=0;
				scanning.getImagen('default.png');
				Ext.getCmp(scanning.id+'-txt-nombre').setValue('');
				Ext.getCmp(scanning.id+'-txt-descripcion').setValue('');
				Ext.getCmp(scanning.id+'-date-re').setValue('');
				Ext.getCmp(scanning.id+'-cmb-estado').setValue('');
				Ext.getCmp(scanning.id+'-txt-nombre').focus();
			},
			getImg_tiff: function(file){//(rec,recA){
				
				var panel = Ext.getCmp(scanning.id+'-panel_img');
                panel.removeAll();
                panel.add({
                    html: '<img id="imagen-scaneo" src="/scanning/'+file+'.jpg" style="width:100%; height:"100%;" >'
                });

                var image = document.getElementById('imagen-scaneo');
				var downloadingImage = new Image();
				downloadingImage.onload = function(){
				    image.src = this.src;
				    //scanning.getDropImg();
	                //scanning.load_file('-panel_texto','imagen-scaneo'); 
	                panel.doLayout();
				};
				downloadingImage.src = '/scanning/'+file+'.jpg';
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
		    }
		}
		Ext.onReady(scanning.init,scanning);
	}else{
		tab.setActiveTab(scanning.id+'-tab');
	}
</script>