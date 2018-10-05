<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('tracking-tab')){
		var tracking = {
			id:'tracking',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/tracking/',
			opcion:'I',
			id_lote:0,
			shi_codigo:0,
			fac_cliente:0,
			lote:0,
			paramsStore:{},
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
	                    {name: 'estado', type: 'string'}
				    ]
				});
				var storeTree = new Ext.data.TreeStore({
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: tracking.url+'get_list_lotizer/'//,
	                    //reader:{
	                    //    type: 'json'//,
	                    //    //rootProperty: 'data'
	                    //}
	                },
	                folderSort: true,
	                listeners:{
	                	beforeload: function (store, operation, opts) {
	                		store.proxy.extraParams = tracking.paramsStore;
					        /*Ext.apply(operation, {
					            params: {
					                to: 'test1',
		    						from: 'test2'
					            }
					       });*/
					    },
	                    load: function(obj, records, successful, opts){
	                 		Ext.getCmp(tracking.id + '-grid-tracking').doLayout();
	                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		storeTree.removeAt(0);
	                 		Ext.getCmp(tracking.id + '-grid-tracking').collapseAll();
		                    Ext.getCmp(tracking.id + '-grid-tracking').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                    });
		                    Ext.getCmp(tracking.id + '-grid-tracking').expandAll();
	                    }
	                }
	            });

				var store_history = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'id_estado', type: 'string'},
	                    {name: 'id_lote', type: 'string'},
	                    {name: 'shi_codigo', type: 'string'},
	                    {name: 'lot_estado', type: 'string'},                    
	                    {name: 'usr_nombre', type: 'string'},
	                    {name: 'fecact', type: 'string'}
	                ],
	                autoLoad:true,
	                proxy:{
	                    type: 'ajax',
	                    url: tracking.url+'get_list_history/',
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
	                    url: tracking.url+'get_list_shipper/',
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
	                    url: tracking.url+'get_list_contratos/',
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

	            var store_plantillas = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'cod_plantilla', type: 'string'},
				        {name: 'shi_codigo', type: 'string'},
				        {name: 'fac_cliente', type: 'string'},
				        {name: 'nombre', type: 'string'},
	                    {name: 'cod_formato', type: 'string'},
	                    {name: 'tot_trazos', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'img', type: 'string'},
	                    {name: 'pathorigen', type: 'string'},
	                    {name: 'imgorigen', type: 'string'},
	                    {name: 'texto', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'fecha', type: 'string'},
	                    {name: 'usuario', type: 'string'},
	                    {name: 'width', type: 'string'},
	                    {name: 'height', type: 'string'},
	                    {name: 'width_formato', type: 'string'},
	                    {name: 'height_formato', type: 'string'},
	                    {name: 'formato', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: tracking.url+'get_ocr_plantillas/',
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

				var store_trazos = Ext.create('Ext.data.Store',{
	                fields: [
	                    {name: 'cod_trazo', type: 'string'},
				        {name: 'cod_plantilla', type: 'string'},
				        {name: 'nombre', type: 'string'},
				        {name: 'tipo', type: 'string'},
	                    {name: 'x', type: 'string'},
	                    {name: 'y', type: 'string'},
	                    {name: 'w', type: 'string'},
	                    {name: 'h', type: 'string'},
	                    {name: 'path', type: 'string'},
	                    {name: 'img', type: 'string'},
	                    {name: 'texto', type: 'string'},
	                    {name: 'estado', type: 'string'},
	                    {name: 'usuario', type: 'string'},
	                    {name: 'fecha', type: 'string'}
	                ],
	                autoLoad:false,
	                proxy:{
	                    type: 'ajax',
	                    url: tracking.url+'get_ocr_trazos/',
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
				var myDataSearch = [
					['L','N° Lote'],
					['N','Nombre Lote'],
				    ['A','Nombre Archivo'],
				    ['G','Nombre Archivo Generado'],
				    ['O','Full Text OCR'],
				    ['T','Texto en Trazo OCR']
				];
				var store_search = Ext.create('Ext.data.ArrayStore', {
			        storeId: 'search',
			        autoLoad: true,
			        data: myDataSearch,
			        fields: ['code', 'name']
			    });
				var panel = Ext.create('Ext.form.Panel',{
					id:tracking.id+'-form',
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
					id:tracking.id+'-tab',
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
		                            width:550,
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
			                                                    id:tracking.id+'-cbx-cliente',
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
			                                                        	Ext.getCmp(tracking.id+'-cbx-contrato').setValue('');
			                                                			tracking.getContratos(records.get('shi_codigo'));
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
			                                                    id:tracking.id+'-cbx-contrato',
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
			                                                        	var shi_codigo = Ext.getCmp(tracking.id+'-cbx-cliente').getValue();
			                                                			Ext.getCmp(tracking.id+'-filter-plantillas').getStore().removeAll();
			                                                			Ext.getCmp(tracking.id+'-filter-trazos').getStore().removeAll();
																		Ext.getCmp(tracking.id+'-filter-plantillas').getStore().load(
															                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:obj.getValue(),vp_name:'',fecha:''},
															                callback:function(){
															                	//Ext.getCmp(tracking.id+'-form').el.unmask();
															                }
															            });
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
		                            width:1100,
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
		                                            width:180,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype:'combo',
		                                                    fieldLabel: 'Por',
		                                                    id:tracking.id+'-filter-por',
		                                                    store: store_search,
		                                                    queryMode: 'local',
		                                                    triggerAction: 'all',
		                                                    valueField: 'code',
		                                                    displayField: 'name',
		                                                    emptyText: '[Seleccione]',
		                                                    labelAlign:'right',
		                                                    //allowBlank: false,
		                                                    labelWidth: 40,
		                                                    width:'100%',
		                                                    anchor:'100%',
		                                                    //readOnly: true,
		                                                    listeners:{
		                                                        afterrender:function(obj, e){
		                                                            Ext.getCmp(tracking.id+'-filter-por').setValue('N');
		                                                        },
		                                                        select:function(obj, records, eOpts){
		                                                        	Ext.getCmp(tracking.id+'-txt-tracking').setValue('');
		                                                			switch(obj.getValue()){
		                                                				case 'T': 
		                                                					Ext.getCmp(tracking.id+'-panel-plantillas').setVisible(true);
		                                                					Ext.getCmp(tracking.id+'-panel-trazos').setVisible(true);
		                                                				break;
		                                                				default: 
		                                                					Ext.getCmp(tracking.id+'-panel-plantillas').setVisible(false);
		                                                					Ext.getCmp(tracking.id+'-panel-trazos').setVisible(false);
		                                                				break;
		                                                			}
		                                                        }
		                                                    }
		                                                }
		                                            ]
		                                        },
		                                        {
		                                            width:150,border:false,
		                                            id:tracking.id+'-panel-plantillas',
		                                            hidden:true,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype:'combo',
		                                                    fieldLabel: 'Plantillas',
		                                                    id:tracking.id+'-filter-plantillas',
		                                                    store: store_plantillas,
		                                                    queryMode: 'local',
		                                                    triggerAction: 'all',
		                                                    valueField: 'cod_plantilla',
		                                                    displayField: 'nombre',
		                                                    emptyText: '[Seleccione]',
		                                                    labelAlign:'right',
		                                                    //allowBlank: false,
		                                                    labelWidth: 50,
		                                                    width:'100%',
		                                                    anchor:'100%',
		                                                    //readOnly: true,
		                                                    listeners:{
		                                                        afterrender:function(obj, e){
		                                                            //Ext.getCmp(tracking.id+'-txt-estado-filter').setValue('N');
		                                                        },
		                                                        select:function(obj, records, eOpts){
		                                                			Ext.getCmp(tracking.id+'-filter-trazos').getStore().removeAll();
																	Ext.getCmp(tracking.id+'-filter-trazos').getStore().load(
														                {params: {vp_cod_plantilla:obj.getValue()},
														                callback:function(){
														                	//Ext.getCmp(tracking.id+'-form').el.unmask();
														                	Ext.getCmp(tracking.id+'-filter-trazos').setValue('');
														                }
														            });
		                                                        }
		                                                    }
		                                                }
		                                            ]
		                                        },
		                                        {
		                                            width:150,border:false,
		                                            id:tracking.id+'-panel-trazos',
		                                            hidden:true,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype:'combo',
		                                                    fieldLabel: 'Trazos',
		                                                    id:tracking.id+'-filter-trazos',
		                                                    store: store_trazos,
		                                                    queryMode: 'local',
		                                                    triggerAction: 'all',
		                                                    valueField: 'cod_trazo',
		                                                    displayField: 'nombre',
		                                                    emptyText: '[Seleccione]',
		                                                    labelAlign:'right',
		                                                    //allowBlank: false,
		                                                    labelWidth: 40,
		                                                    width:'100%',
		                                                    anchor:'100%',
		                                                    //readOnly: true,
		                                                    listeners:{
		                                                        afterrender:function(obj, e){
		                                                            //Ext.getCmp(tracking.id+'-txt-estado-filter').setValue('N');
		                                                        },
		                                                        select:function(obj, records, eOpts){
		                                                			
		                                                        }
		                                                    }
		                                                }
		                                            ]
		                                        },
		                                        {
		                                            width:150,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: '',
		                                                    id:tracking.id+'-txt-tracking',
		                                                    labelWidth:0,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
			                                        width: 140,border:false,
			                                        padding:'0px 2px 0px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                        items:[
			                                            {
			                                                xtype:'datefield',
			                                                id:tracking.id+'-txt-fecha-filtro',
			                                                fieldLabel:'Fecha',
			                                                labelWidth:50,
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
			                                   		width: 130,border:false,
			                                    	padding:'0px 2px 0px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Estado',
			                                                    id:tracking.id+'-txt-estado-filter',
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
			                                                            Ext.getCmp(tracking.id+'-txt-estado-filter').setValue('A');
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
		                               					            tracking.getReloadGridtracking();
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
											layout:'border',
											border:false,
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
									                        id: tracking.id + '-grid-tracking',
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
								                                    text: 'Estado',
								                                    dataIndex: 'lot_estado',
								                                    loocked : true,
								                                    width: 50,
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
																	        	case 'DI':
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
								                                            id_menu: tracking.id_menu,
								                                            icons:[
								                                                {id_serv: 8, img: estado, qtip: qtip, js: ""}
								                                            ]
								                                        });
								                                    }
								                                },
								                                {
								                                    text: 'Fecha',
								                                    dataIndex: 'fecha',
								                                    width: 140,
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
								                                    width: 50,
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
								                                        var estado = (record.get('estado')=='A')?'check-circle-green-16.png':'check-circle-red.png';
								                                        var qtip = (record.get('estado')=='A')?'Estado del Lote Activo.':'Estado del Lote Inactivo.';
								                                        return global.permisos({
								                                            type: 'link',
								                                            id_menu: tracking.id_menu,
								                                            icons:[
								                                                {id_serv: 8, img: estado, qtip: qtip, js: ""}
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
									                                //tracking.getImagen('default.png');
									                                Ext.getCmp(tracking.id + '-grid-tracking').getStore().removeAll();
		        													Ext.getCmp(tracking.id + '-grid-tracking').getView().refresh();
									                            },
																beforeselect:function(obj, record, index, eOpts ){
																	tracking.getStatusPanel(record.get('lot_estado'));
																	tracking.getHistory(record.get('id_lote'));

																	//document.getElementById('imagen-tracking').innerHTML='<img src="'+record.get('path')+record.get('img')+'" width="100%" height="100%" />'
																	
																	

																	var image = document.getElementById('imagen-tracking-img');
																	var downloadingImage = new Image();
																	downloadingImage.onload = function(){
																	    image.src = this.src;   
																	    Ext.getCmp(tracking.id + '-panel-imagen').doLayout();
																	};
																	downloadingImage.src = record.get('path')+record.get('img');
																	//console.log(record);
																	/*tracking.opcion='U';*/
																	/*tracking.id_lote=record.get('id_lote');
																	/*tracking.getImagen(record.get('imagen'));*/
																	/*Ext.getCmp(tracking.id+'-txt-nombre').setValue(record.get('nombre'));
																	Ext.getCmp(tracking.id+'-txt-tipdoc').setValue(record.get('tipdoc'));
																	Ext.getCmp(tracking.id+'-txt-fecha').setValue(record.get('fecha'));
																	Ext.getCmp(tracking.id+'-txt-estado').setValue(record.get('estado'));
																	Ext.getCmp(tracking.id+'-txt-tot_folder').setValue(record.get('tot_folder'));

																	Ext.getCmp(tracking.id+'-txt-nombre').setReadOnly(true);
																	Ext.getCmp(tracking.id+'-txt-tipdoc').setReadOnly(true);
																	Ext.getCmp(tracking.id+'-txt-fecha').setReadOnly(true);
																	Ext.getCmp(tracking.id+'-txt-estado').setReadOnly(true);
																	Ext.getCmp(tracking.id+'-txt-tot_folder').setReadOnly(true);


																	var botonTxt = Ext.getCmp('boton').getText();
																	if (botonTxt == 'Guardar' || botonTxt == 'Update') {
																		Ext.getCmp('boton').setText('Editar');
																		Ext.getCmp('boton').setIcon('/images/icon/editar.png');
																	}*/

																	//tracking.getReloadGridtracking2(tracking.id_lote);

																}
									                        }
									                    }
													]
												}
							                ]
							            },
										{
											region:'south',
											//width:'100%',
											height:140,
											layout:'fit',
											items:[
												{
							                        xtype: 'dataview',
							                        id: tracking.id+'-check-status',
							                        layout:'fit',
							                        store: store_estados,
							                        autoScroll: true,
							                        loadMask:true,
							                        autoHeight: false,
							                        tpl: imageTplPointer,
							                        multiSelect: false,
							                        singleSelect: false,
							                        loadingText:'Cargando Estados...',
							                        itemSelector: 'div.thumb-wrap',
							                        emptyText: '<div class="databox_list_pointer"><div class="databox_none_data" ></div><div class="databox_title_clear_data">NO TIENE NINGUN ESTADO</div></div>',
							                        itemSelector: 'div.databox_list_pointer',
							                        trackOver: true,
							                        overItemCls: 'databox_list_pointer-hover',
							                        listeners: {
							                            'itemclick': function(view, record, item, idx, event, opts) {
							                                /*me.idx=idx;
							                                if(config.msn)me.filtra_novedad(record);
							                                if(config.hist)me.reload_historico();
							                                if(config.records)config.records(view, record, item, idx, event, opts,'N');*/
							                            },
							                            'afterrender':function(){
							                                /*Ext.getCmp(config.id+'-nov-lista').refresh();
							                                Ext.getCmp(config.id+'-nov-lista').refresh();*/
							                            }
							                        }
							                    }
											]
										}
									]
									
								},
								{
									region:'east',
									title:'Historia',
									//width:'100%',
									width:500,
									items:[
										{
											region:'north',
											layout:'fit',
											height:200,
											border:false,
											items:[
												{
							                        xtype: 'grid',
							                        id: tracking.id + '-grid-history',
							                        store: store_history, 
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
							                                    text: 'ST',
							                                    dataIndex: 'lot_estado',
							                                    //loocked : true,
							                                    width: 40,
							                                    align: 'center'/*,
							                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
							                                        //console.log(record);
							                                        metaData.style = "padding: 0px; margin: 0px";
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: tracking.id_menu,
							                                            icons:[
							                                                {id_serv: 8, img: 'recicle_nov.ico', qtip: 'Click para Desactivar Lote.', js: "tracking.setRemoveEscaner(false,'"+record.get('file')+"')"}

							                                            ]
							                                        });
							                                    }*/
							                                },
							                                {
							                                    text: 'Historia',
							                                    dataIndex: 'fecact',
							                                    flex: 1
							                                },
							                                {
							                                    text: 'Usuario',
							                                    dataIndex: 'usr_nombre',
							                                    width: 200
							                                }
							                            ],
							                            defaults:{
							                                menuDisabled: true
							                            }
							                        },
							                        multiSelect: true,
							                        trackMouseOver: false,
							                        listeners:{
							                            afterrender: function(obj){
							                                
							                            },
							                            beforeselect:function(obj, record, index, eOpts ){
							                            	//scanning.setImageFile(record.get('path'),record.get('file'));
							                            }
							                        }
							                    }
											]
										},
										{
											region:'center',
											id: tracking.id + '-panel-imagen',
											title:'Imagen',
											//width:'100%',
											//width:500,
											html: '<div id="imagen-tracking" style="width:100%; height:"100%;overflow: none;" ><img id="imagen-tracking-img" src="/plantillas/Document-Scanning-Indexing-Services-min.jpg" width="100%" height="100%"/></div>'
										}
									]
								}
							]
						}
					],
					listeners:{
						beforerender: function(obj, opts){
	                        global.state_item_menu(tracking.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                    	//tracking.getReloadGridtracking('');
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,tracking.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(tracking.id_menu, false);
	                    }
					}

				}).show();
			},
			getStatusPanel: function(ES) {
		        Ext.getCmp(tracking.id+'-check-status').getStore().removeAll();
		        switch(ES){
		        	case 'N':
		        		Ext.getCmp(tracking.id+'-check-status').getStore().loadData([['databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'LT':
		        		Ext.getCmp(tracking.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'ES':
		        		Ext.getCmp(tracking.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'CO':
		        		Ext.getCmp(tracking.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'RE':
		        		Ext.getCmp(tracking.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color_red','databox_interno_color','databox_interno_color']]);
		        	break;
		        	case 'DI':
		        		Ext.getCmp(tracking.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color_green','databox_interno_color']]);
		        	break;
		        	case 'DE':
		        		Ext.getCmp(tracking.id+'-check-status').getStore().loadData([['databox_interno_color_green','databox_interno_color_green','databox_interno_color_green','databox_interno_color','databox_interno_color_green','databox_interno_color_blue']]);
		        	break;
		        }
		    },
		    getHistory:function(lo){
		    	if(tracking.lote!=parseInt(lo)){
		    		tracking.lote=parseInt(lo);
			    	Ext.getCmp(tracking.id + '-grid-history').getStore().removeAll();
					Ext.getCmp(tracking.id + '-grid-history').getStore().load(
		                {params: {vp_lote:tracking.lote},
		                callback:function(){
		                	//Ext.getCmp(tracking.id+'-form').el.unmask();
		                }
		            });
	            }
		    },
			getImagen:function(param){
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/images/icon/'+param}});///tracking/
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(tracking.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(tracking.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(tracking.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridtracking:function(){
				//Ext.getCmp(tracking.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				tracking.lote=0;
				Ext.getCmp(tracking.id + '-grid-history').getStore().removeAll();
				tracking.getStatusPanel('N');
				var vp_op = Ext.getCmp(tracking.id+'-filter-por').getValue();
				var shi_codigo = Ext.getCmp(tracking.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(tracking.id+'-cbx-contrato').getValue();

				var lote = 0;//Ext.getCmp(tracking.id+'-txt-lote').getValue();

				var vp_cod_trazo=Ext.getCmp(tracking.id+'-filter-trazos').getValue();
				var name = Ext.getCmp(tracking.id+'-txt-tracking').getValue();



				var estado = Ext.getCmp(tracking.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(tracking.id+'-txt-fecha-filtro').getRawValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }

		        if(vp_op=='L'){
					lote=name;
					name='';
				}

		        if(lote== null || lote==''){
		        	if(vp_op=='L'){
		        		global.Msg({msg:"Ingrese un Lote.",icon:2,fn:function(){}});
		            	return false;
		        	}
		        	lote=0;
		        }
		        if(vp_op=='T'){
			        if(vp_cod_trazo== null || vp_cod_trazo==''){
			            global.Msg({msg:"Seleccione un Trazo por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			    }else{
			    	vp_cod_trazo=0;
			    }
				/*
				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }*/
		        Ext.getCmp(tracking.id + '-grid-tracking').getStore().removeAll();
		        Ext.getCmp(tracking.id + '-grid-tracking').getView().refresh();
		        tracking.paramsStore={vp_op:vp_op,vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_cod_trazo:vp_cod_trazo,vp_lote_estado:'',vp_name:name,fecha:fecha,vp_estado:estado};
		        Ext.getCmp(tracking.id + '-grid-tracking').getStore().load(
	                {params: tracking.paramsStore,
	                callback:function(){
	                	//Ext.getCmp(tracking.id+'-form').el.unmask();
	                }
	            });
			}

		}
		Ext.onReady(tracking.init,tracking);
	}else{
		tab.setActiveTab(tracking.id+'-tab');
	}
</script>