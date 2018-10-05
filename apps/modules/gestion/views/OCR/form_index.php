<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('OCR-tab')){
		var OCR = {
			id:'OCR',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/OCR/',
			opcion:'I',
			cod_trazo:0,
			cod_plantilla:0,
			cropper:'',
			imagen_trazo:'',
			cropperData:{},
			parametros:{
				vp_op:'I',
		        vp_cod_plantilla:0,
		        vp_shi_codigo:0,
		        vp_fac_cliente:0,
		        vp_nombre:'',
		        vp_cod_formato:1,
		        vp_width:0,
		        vp_height:0, 
		        vp_path:'',
		        vp_img:'',
		        vp_pathorigen:'',
		        vp_imgorigen:'',
		        vp_texto:'',
		        vp_estado:'A'
			},
			init:function(){
				Ext.tip.QuickTipManager.init();
				Ext.Ajax.timeout = 300000;

				Ext.define('Task', {
				    extend: 'Ext.data.TreeModel',
				    fields: [
				        {name: 'hijo', type: 'string'},
				        {name: 'padre', type: 'string'},
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
				OCR.storeTree = new Ext.data.TreeStore({
	                model: 'Task',
				    autoLoad:false,
	                proxy: {
	                    type: 'ajax',
	                    url: OCR.url+'get_list_lotizer/'//,
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
	                 		Ext.getCmp(OCR.id + '-grid-lote').doLayout();
	                 		//Ext.getCmp(lotizer.id + '-grid').getView().getRow(0).style.display = 'none';
	                 		OCR.storeTree.removeAt(0);
	                 		Ext.getCmp(OCR.id + '-grid-lote').collapseAll();
		                    Ext.getCmp(OCR.id + '-grid-lote').getRootNode().cascadeBy(function (node) {
		                          if (node.getDepth() < 1) { node.expand(); }
		                          if (node.getDepth() == 0) { return false; }
		                     });
		                    Ext.getCmp(OCR.id + '-grid-lote').expandAll();
	                    }
	                }
	            });

				var store = Ext.create('Ext.data.Store',{
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
	                    url: OCR.url+'get_ocr_plantillas/',
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
	                    url: OCR.url+'get_ocr_trazos/',
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
				
			this.msgTpl = new Ext.Template(
	            'Sounds Effects: <b>{fx}%</b><br />',
	            'Ambient Sounds: <b>{ambient}%</b><br />',
	            'Interface Sounds: <b>{iface}%</b>'
	        );
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
                    url: OCR.url+'get_list_shipper/',
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
                    url: OCR.url+'get_list_contratos/',
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

		    var myDataTipo = [
				['S','Texto'],
			    ['N','Número']
			];
			var store_tipo_texto = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'tipo',
		        autoLoad: true,
		        data: myDataTipo,
		        fields: ['code', 'name']
		    });
			
			var myData = [
			    ['A','Activo'],
			    ['I','Inactivo']
			];
			var store_estado = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'estado',
		        autoLoad: true,
		        data: myData,
		        fields: ['code', 'name']
		    });
		    var myDataFormato = [
			    [1,'A4'],
			    [2,'A5']
			];
			var store_formato = Ext.create('Ext.data.ArrayStore', {
		        storeId: 'formato',
		        autoLoad: true,
		        data: myDataFormato,
		        fields: ['code', 'name']
		    });

				var panel = Ext.create('Ext.form.Panel',{
					id:OCR.id+'-form',
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
		                            title: 'Busqueda de Plantillas',
		                            legend: 'Seleccione Plantilla Registrada',
		                            width:350,
		                            height:180,
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
				                                            id:OCR.id+'-cbx-cliente',
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
				                                                	Ext.getCmp(OCR.id+'-cbx-contrato').setValue('');
				                                        			OCR.getContratos(records.get('shi_codigo'));
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
			                                                    id:OCR.id+'-cbx-contrato',
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
		                                                    fieldLabel: 'Nombre',
		                                                    id:OCR.id+'-txt-OCR',
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
			                                                id:OCR.id+'-txt-fecha-filtro',
			                                                padding:'0px 10px 0px 0px',  
			                                                fieldLabel:'Fecha',
			                                                labelWidth: 50,
			                                                labelAlign:'right',
			                                                value:'',
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
		                               					            OCR.getReloadGridOCR();
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
											region:'north',
											title:'Mantenimiento Plantilla',
											border:false,
											bodyStyle: 'background: transparent',
											padding:'5px 5px 5px 5px',
											height:210,
											bbar:[
												{
							                        xtype:'button',
							                        hidden:true,
							                        //width:100,
							                        text: 'Eliminar',
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
		                       					            //OCR.setOCRTrazos({op:'D',top: 0,left: 0,width: 0,height: 0});
							                            }
							                        }
							                    },
												'->',
												{
							                        xtype:'button',
							                        //width:100,
							                        text: 'Nuevo',
							                        icon: '/images/icon/app_add.png',
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
							                            	OCR.setNuevoPlantilla();
							                            }
							                        }
							                    },
												{
							                        xtype:'button',
							                        //width:100,
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
							                            	//var name = Ext.getCmp(OCR.id+'-txt-texto-trazo').getValue();
		                       					            //OCR.setOCRTrazos(name);
		                       					            //var op = OCR.cod_trazo==0?'I':'U';
		                       					            //OCR.getSizeImg('/scanning/escaneado.jpg',op,OCR.cropper.getCropBoxData(),OCR.getResizeOrigin);
		                       					            OCR.setPlantillas();
							                            }
							                        }
							                    }
											],
											items:[
												{
		                                            width:'100%',border:false,
		                                            padding:'5px 5px 5px 5px',
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre',
		                                                    id:OCR.id+'-txt-nombre-plantilla-man',
		                                                    labelWidth:60,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
												{
			                                   		width: '100%',border:false,
			                                    	padding:'5px 5px 5px 5px',
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Formato',
			                                                    id:OCR.id+'-cbx-formato',
			                                                    store: store_formato,
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
			                                                            obj.setValue(1);
			                                                        },
			                                                        select:function(obj, records, eOpts){ 
			                                                			
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
			                                    {
			                                   		width: '100%',border:false,
			                                    	padding:'5px 5px 5px 5px',
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Estado',
			                                                    id:OCR.id+'-cbx-estado-man',
			                                                    store: store_estado,
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
			                                                            obj.setValue('A');
			                                                        },
			                                                        select:function(obj, records, eOpts){ 
			                                                			
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
			                                    {
		                                            width:'100%',border:false,
		                                            padding:'5px 5px 5px 5px',
		                                            bodyStyle: 'background: transparent',
		                                            layout:'hbox',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Imagen',
		                                                    id:OCR.id+'-txt-imagen-man',
		                                                    readOnly:true,
		                                                    //disabled:true,
		                                                    labelWidth:60,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'90%',
		                                                    anchor:'90%'
		                                                },
		                                                {
									                        xtype:'button',
									                        id:OCR.id+'-btn-imagen-man',
									                        //disabled:true,
									                        width:'9%',
		                                                    anchor:'9%',
									                        text: '',
									                        icon: '/images/icon/page_find.png',
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
									                            	OCR.getFormPage();
									                            }
									                        }
									                    }
		                                            ]
		                                        }
											]
										},
										{
											region:'center',
											layout:'fit',
											border:false,
											padding:'5px 5px 5px 5px',
											items:[
												{
							                        xtype: 'grid',
							                        id: OCR.id + '-grid',
							                        store: store,
							                        columnLines: true,
							                        columns:{
							                            items:[
							                                {
							                                    text: 'Nombre',
							                                    dataIndex: 'nombre',
							                                    flex: 1
							                                },
							                                {
							                                    text: 'Formato',
							                                    dataIndex: 'formato',
							                                    width: 50
							                                },
							                                {
							                                    text: 'Trazos',
							                                    dataIndex: 'tot_trazos',
							                                    width: 50
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
							                                        var qtip = (record.get('estado')=='A')?'Estado Activo.':'Estado Inactivo.';
							                                        return global.permisos({
							                                            type: 'link',
							                                            id_menu: OCR.id_menu,
							                                            icons:[
							                                                {id_serv: 6, img: estado, qtip: qtip, js: ""}
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
															OCR.setInfoPlantilla(index);
															OCR.getReloadGridOCRTRAZOS(record.get('cod_plantilla'));
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
							autoScroll:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'north',
									hidden:true,
									border:false,
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
									id: OCR.id+'-panel_img',
									border:true,
									autoScroll:true,
									padding:'5px 5px 5px 5px',
									html:'<img id="imagen-plantilla" src="" style="width:100%; overflow: scroll;" />'
								},
								{
									region:'south',
									split:true,
									id: OCR.id+'-panel_texto',
									height:100,
									border:true,
									autoScroll:true,
									padding:'5px 5px 5px 5px',
									layout:'fit',
									items:[
										{
                                            xtype: 'textarea',	
                                            //fieldLabel: 'Texto',
                                            id:OCR.id+'-txt-texto-plantilla',
                                            labelWidth:0,
                                            //maskRe: /[0-9]/,
                                            //readOnly:true,
                                            labelAlign:'right',
                                            width:'100%',
                                            anchor:'100%'
                                        }
									]
								}
							]
						},
						{
							region:'east',
							border:true,
							width:'20%',
							layout:'border',
							border:true,
							padding:'5px 5px 5px 5px',
							items:[
								{
									region:'north',
									id:OCR.id+'-panel-trazos-form',
									border:true,
									height:300,
									padding:'5px 5px 5px 5px',
									bodyStyle: 'background: transparent',
									layout: 'border',
									bbar:[
										{
					                        xtype:'button',
					                        //width:100,
					                        text: 'Eliminar',
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
                       					            OCR.setOCRTrazos({op:'D',top: 0,left: 0,width: 0,height: 0});
					                            }
					                        }
					                    },
										'->',
										{
					                        xtype:'button',
					                        //width:100,
					                        text: 'Nuevo',
					                        icon: '/images/icon/app_add.png',
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
					                            	OCR.setNuevo();
					                            }
					                        }
					                    },
										{
					                        xtype:'button',
					                        //width:100,
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
					                            	//var name = Ext.getCmp(OCR.id+'-txt-texto-trazo').getValue();
                       					            //OCR.setOCRTrazos(name);
                       					            var op = OCR.cod_trazo==0?'I':'U';
                       					            OCR.getSizeImg(OCR.parametros.vp_path+OCR.parametros.vp_img,op,OCR.cropper.getCropBoxData(),OCR.getResizeOrigin);
					                            }
					                        }
					                    }
									],
									items:[
										{
											region:'north',
											height:140,
											border:false,
											bodyStyle: 'background: transparent',
		                                    padding:'2px 5px 1px 5px',
		                                    layout:'column',
											items:[
												{
			                                   		width: '100%',border:false,
			                                    	padding:'10px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
			                                 		items:[
			                                                {
			                                                    xtype:'combo',
			                                                    fieldLabel: 'Tipo Texto',
			                                                    id:OCR.id+'-cbx-tipo-texto',
			                                                    store: store_tipo_texto,
			                                                    queryMode: 'local',
			                                                    triggerAction: 'all',
			                                                    valueField: 'code',
			                                                    displayField: 'name',
			                                                    emptyText: '[Seleccione]',
			                                                    labelAlign:'right',
			                                                    //allowBlank: false,
			                                                    labelWidth: 70,
			                                                    width:'100%',
			                                                    anchor:'100%',
			                                                    //readOnly: true,
			                                                    listeners:{
			                                                        afterrender:function(obj, e){
			                                                            // obj.getStore().load();
			                                                            obj.setValue('S');
			                                                        },
			                                                        select:function(obj, records, eOpts){ 
			                                                			
			                                                        }
			                                                    }
			                                                }
			                                 		]
			                                    },
												{
		                                            width:'100%',border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre',
		                                                    id:OCR.id+'-txt-nombre-trazo',
		                                                    labelWidth:70,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
		                                            width:'100%',border:false,
		                                            hidden:true,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            layout:'hbox',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    padding:'0px 0px 10px 0px',  
		                                                    fieldLabel: 'X',
		                                                    id:OCR.id+'-txt-x',
		                                                    labelWidth:50,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'25%',
		                                                    anchor:'25%'
		                                                },
		                                                {
		                                                    xtype: 'textfield',	
		                                                    padding:'0px 0px 10px 0px',  
		                                                    fieldLabel: 'Y',
		                                                    id:OCR.id+'-txt-y',
		                                                    labelWidth:50,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'25%',
		                                                    anchor:'25%'
		                                                },
		                                                {
		                                                    xtype: 'textfield',	
		                                                    padding:'0px 0px 10px 0px',  
		                                                    fieldLabel: 'W',
		                                                    id:OCR.id+'-txt-w',
		                                                    labelWidth:50,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'25%',
		                                                    anchor:'25%'
		                                                },
		                                                {
		                                                    xtype: 'textfield',	
		                                                    padding:'0px 0px 10px 0px',  
		                                                    fieldLabel: 'H',
		                                                    id:OCR.id+'-txt-h',
		                                                    labelWidth:50,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'25%',
		                                                    anchor:'25%'
		                                                }
		                                            ]
		                                        },
		                                        {
		                                        	id: OCR.id + '-panel-img-texto',
		                                            width:'100%',border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textarea',	
		                                                    fieldLabel: 'Texto',
		                                                    id:OCR.id+'-txt-texto-trazo',
		                                                    labelWidth:70,
		                                                    //maskRe: /[0-9]/,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        }
											]
										},
										{
											region:'center',
											bodyStyle: 'background: transparent',
											id: OCR.id + '-panel-img-trazos',
											border:true,
											html: '<img id="imagen-trazo" src="" style="width:100%; height:100%;overflow: scroll;" />'
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
					                        xtype: 'grid',
					                        id: OCR.id + '-grid-trazos',
					                        store: store_trazos,
					                        columnLines: true,
					                        columns:{
					                            items:[
					                                {
					                                    text: 'nombre',
					                                    dataIndex: 'nombre',
					                                    flex: 1
					                                },
					                                {
					                                    text: 'Tipo',
					                                    dataIndex: 'tipo',
					                                    width: 50
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
					                                        var qtip = (record.get('estado')=='A')?'Estado Activo.':'Estado Inactivo.';
					                                        return global.permisos({
					                                            type: 'link',
					                                            id_menu: OCR.id_menu,
					                                            icons:[
					                                                {id_serv: 6, img: estado, qtip: qtip, js: ""}
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
													OCR.setViewPanelTrazo(index);
												}
					                        }
					                    }
									]
								}
							]
						}
					]
				});
				tab.add({
					id:OCR.id+'-tab',
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
	                        global.state_item_menu(OCR.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,OCR.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(OCR.id_menu, false);
	                    }
					}

				}).show();
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
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/OCR/'+param}});
			},
			setOCRTrazos:function(resp){
				//var res = Ext.JSON.decode(name);
				console.log(resp);
				var tipo = Ext.getCmp(OCR.id+'-cbx-tipo-texto').getValue();
				var nombre = Ext.getCmp(OCR.id+'-txt-nombre-trazo').getValue();
				var texto = Ext.getCmp(OCR.id+'-txt-texto-trazo').getValue();
				//OCR.cod_trazo=record.data.cod_trazo;
				//OCR.cod_plantilla=record.data.cod_plantilla;
				/*Ext.getCmp(OCR.id+'-txt-x').getValue();
				Ext.getCmp(OCR.id+'-txt-y').getValue();
				Ext.getCmp(OCR.id+'-txt-w').getValue();
				Ext.getCmp(OCR.id+'-txt-h').getValue();*/
				if(OCR.parametros.vp_shi_codigo==0){
		            global.Msg({msg:"Seleccione un cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }

				if(OCR.cod_plantilla==0){
		            global.Msg({msg:"Seleccione una plantilla por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(resp.op=='U' || resp.op=='D'){
			        if(OCR.cod_trazo==0){
			            global.Msg({msg:"Seleccione un Trazo por favor.",icon:2,fn:function(){}});
			            return false;
			        }
			    }

		        if(resp.op=='I' || resp.op=='U'){
					if(tipo== null || tipo==''){
			            global.Msg({msg:"Seleccione un tipo por favor.",icon:2,fn:function(){}});
			            return false;
			        }

			        if(nombre== null || nombre==''){
			            global.Msg({msg:"Ingrese un nombre por favor.",icon:2,fn:function(){}});
			            return false;
			        }
		        }

				var msg_='¿Está seguro de guardar?';
				var ico = 3;
				if(resp.op=='U'){
					msg_='¿Está seguro de Actualizar?';
				}
				if(resp.op=='D'){
					msg_='¿Está seguro de Eliminar?';
					ico=2;
				}

				global.Msg({
                    msg: msg_,
                    icon: ico,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(OCR.id+'-panel-trazos-form').el.mask('Cargando…', 'x-mask-loading');
	                        Ext.Ajax.request({
			                    url: OCR.url + 'set_ocr_trazos/',
			                    params:{
			                    	vp_op:resp.op,
							        vp_cod_trazo:OCR.cod_trazo,
							        vp_cod_plantilla:OCR.cod_plantilla,
							        vp_shi_codigo:OCR.parametros.vp_shi_codigo,
							        vp_nombre:nombre,
							        vp_tipo:tipo,
							        vp_y:resp.top,
							        vp_x:resp.left,
							        vp_w:resp.width,
							        vp_h:resp.height,
							        vp_path:'',
							        vp_img:OCR.parametros.vp_img,
							        vp_imagen_trazo:OCR.imagen_trazo,
							        vp_width:OCR.parametros.vp_width,
							        vp_height:OCR.parametros.vp_height,
							        vp_texto:texto,
							        vp_estado:'A'
			                    },
			                    timeout: 300000,
			                    success: function(response, options){
			                    	Ext.getCmp(OCR.id+'-panel-trazos-form').el.unmask();
			                        var res = Ext.JSON.decode(response.responseText);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	if (parseInt(res.cod_trazo) != 0){
				                                	/*var panel = Ext.getCmp(OCR.id + '-panel-img-trazos');
									                panel.removeAll();
									                panel.add({
									                    html: '<img id="imagen-trazo" src="'+res.img+'" style="width:100%; height:"100%;overflow: scroll;" >'//style=""
									                });
									                panel.doLayout();
									                //OCR.getDropImg();
									                OCR.load_file('-panel_texto','imagen-trazo');*/
									                if(resp.op=='I' || resp.op=='U'){
									                	OCR.cod_trazo = parseInt(res.cod_trazo);
										                var image = document.getElementById('imagen-trazo');
														var downloadingImage = new Image();
														downloadingImage.onload = function(){
														    image.src = this.src;
														    //OCR.getSizeImg('/scanning/escaneado.jpg','S',{left:record.data.x,top:record.data.y,width:record.data.w,height:record.data.h},OCR.getResizeOrigin);
														    OCR.getTextoImage();
														};
														downloadingImage.src = res.img;
													}else{
														OCR.setNuevo();
													}
								            	}else{
								            		OCR.setNuevo();
								            	}
			                                    OCR.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    OCR.getReloadGridOCRTRAZOS(OCR.cod_plantilla);
			                                }
			                            });
			                        }
			                    }
			                });
						}
		            }
                });
			},
			setOCR:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(OCR.id+'-form').el.mask('Cargando…', 'x-mask-loading');

							Ext.getCmp(OCR.id+'-form-info').submit({
			                    url: OCR.url + 'setRegisterCampana/',
			                    params:{
			                        vp_op: OCR.opcion,
			                        vp_shi_codigo:OCR.cod_cam,
			                        vp_shi_nombre:Ext.getCmp(OCR.id+'-txt-nombre').getValue(),
			                        vp_shi_descripcion:Ext.getCmp(OCR.id+'-txt-descripcion').getValue(),
			                        vp_fec_ingreso:Ext.getCmp(OCR.id+'-date-re').getRawValue(),
			                        vp_estado:Ext.getCmp(OCR.id+'-cmb-estado').getValue()
			                    },
			                    timeout: 300000,
			                    success: function( fp, o ){
			                    	//console.log(o);
			                        var res = o.result;
			                        Ext.getCmp(OCR.id+'-form').el.unmask();
			                        //console.log(res);
			                        if (parseInt(res.error) == 0){
			                            global.Msg({
			                                msg: res.data,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                    OCR.getReloadGridOCR();
			                                    OCR.setNuevo();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: 'Ocurrio un error intentalo nuevamente.',
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    OCR.getReloadGridOCR();
			                                    OCR.setNuevo();
			                                }
			                            });
			                        }
			                    }
			                });
						}
		            }
                });
			},
			getContratos:function(shi_codigo){
				Ext.getCmp(OCR.id+'-cbx-contrato').getStore().removeAll();
				Ext.getCmp(OCR.id+'-cbx-contrato').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo},
	                callback:function(){
	                	//Ext.getCmp(OCR.id+'-form').el.unmask();
	                }
	            });
			},
			
			setViewPanelTrazo:function(index){
				var record=Ext.getCmp(OCR.id + '-grid-trazos').getStore().getAt(index);
				OCR.cod_trazo=record.data.cod_trazo;
				OCR.cod_plantilla=record.data.cod_plantilla;
				OCR.imagen_trazo=record.data.img;
				Ext.getCmp(OCR.id+'-cbx-tipo-texto').setValue(record.data.tipo);
				Ext.getCmp(OCR.id+'-txt-nombre-trazo').setValue(record.data.nombre);
				Ext.getCmp(OCR.id+'-txt-texto-trazo').setValue(record.data.texto);
				Ext.getCmp(OCR.id+'-txt-x').setValue(record.data.x);
				Ext.getCmp(OCR.id+'-txt-y').setValue(record.data.y);
				Ext.getCmp(OCR.id+'-txt-w').setValue(record.data.w);
				Ext.getCmp(OCR.id+'-txt-h').setValue(record.data.h);
				/*
				var panel = Ext.getCmp(OCR.id + '-panel-img-trazos');
                panel.removeAll();
                panel.add({
                    html: '<img id="imagen-trazo" src="'+record.data.path+record.data.img+'" style="width:100%; height:100%;overflow: scroll;" />'//style=""
                });
                panel.doLayout();
                */
                /*
                $("#imagen-trazo").imagesLoaded().done( function( instance ) {
                	OCR.getSizeImg('/scanning/escaneado.jpg','S',{left:record.data.x,top:record.data.y,width:record.data.w,height:record.data.h},OCR.getResizeOrigin);
				    if(record.data.texto==''){
						OCR.getTextoImage();
					}
				}).attr('src', record.data.path+record.data.img);*/

				var image = document.getElementById('imagen-trazo');
				var downloadingImage = new Image();
				downloadingImage.onload = function(){
				    image.src = this.src;   
				    OCR.getSizeImg(OCR.parametros.vp_path+OCR.parametros.vp_img,'S',{left:record.data.x,top:record.data.y,width:record.data.w,height:record.data.h},OCR.getResizeOrigin);
				    if(record.data.texto==''){
						OCR.getTextoImage();
					}
				};
				downloadingImage.src = record.data.path+record.data.img;

				/*var img =document.getElementById('imagen-trazo');
				if(img!=null){
					if(record.data.texto==''){
						OCR.getTextoImage();
					}
				}*/
			},
			getTextoImage:function(){
				var img = document.getElementById('imagen-trazo');
				var tipo = Ext.getCmp(OCR.id+'-cbx-tipo-texto').getValue();
				var n= (tipo=='S')?false:true;
				try{
					OCRAD(img,{
						numeric: n
					},
					function(text){
						Ext.getCmp(OCR.id+'-txt-texto-trazo').setValue(text);
					});
				}catch(err) {
				    console.log(err.message);
				}
			},
			getResizeOrigin:function(op,jsona,jsonb){
				var container=OCR.cropper.getContainerData();
				var wa = jsona.width /  parseFloat(container.width);
				var wb = jsona.height / parseFloat(container.height);
				console.log('xim');
				console.log(wa);
				console.log(wb);
				console.log(jsona.width);
				console.log(jsona.height);
				console.log(container.width);
				console.log(container.height);
				console.log('end');
				if(op=='S'){
					$('#OCR-panel_img-body').scrollTop(parseFloat(jsonb.top) / wb);
					OCR.cropper.setCropBoxData({
		              top: parseFloat(jsonb.top) / wb,
		              left: parseFloat(jsonb.left)/ wa,
		              width: parseFloat(jsonb.width)/ wa,
		              height: parseFloat(jsonb.height) / wb
		            });
				}else{
                 	OCR.setOCRTrazos(
                 		{
                 		  op:op,
			              top: parseFloat(jsonb.top) * wb,
			              left: parseFloat(jsonb.left)* wa,
			              width: parseFloat(jsonb.width)* wa,
			              height: parseFloat(jsonb.height)* wb
			            }
                 	);
				}
			},
			getSizeImg:function(imgSrc,op,json,callback){
				var newImg = new Image();
			    newImg.onload = function () {
			    	var imgWidth = newImg.width || newImg.naturalWidth;
					var imgHeight = newImg.height || newImg.naturalHeight;
					console.log(imgWidth)
					console.log(imgHeight)
			        if (callback != undefined)callback(op,{width: imgWidth, height: imgHeight},json)
			    }
				console.log('xim');
				console.log(imgSrc);
				console.log('end');
			    newImg.src = imgSrc;
			},
			getReloadGridOCR:function(){
				//OCR.set_OCR_clear();
				//Ext.getCmp(OCR.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				var name = Ext.getCmp(OCR.id+'-txt-OCR').getValue();
				var shi_codigo = Ext.getCmp(OCR.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(OCR.id+'-cbx-contrato').getValue();
				//var lote = Ext.getCmp(OCR.id+'-txt-lote').getValue();
				var name = Ext.getCmp(OCR.id+'-txt-OCR').getValue();
				var estado = 'A';//Ext.getCmp(OCR.id+'-txt-estado-filter').getValue();
				var fecha = Ext.getCmp(OCR.id+'-txt-fecha-filtro').getRawValue();

				if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        /*if(lote== null || lote==''){
		        	lote=0;
		        }/*/
				/*if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }*/
				Ext.getCmp(OCR.id + '-grid').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote_estado:'LT',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(OCR.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridOCRTRAZOS:function(id){
				Ext.getCmp(OCR.id + '-grid-trazos').getStore().removeAll();
				Ext.getCmp(OCR.id + '-grid-trazos').getStore().load(
	                {params: {vp_cod_plantilla:id},
	                callback:function(){
	                	//Ext.getCmp(OCR.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				OCR.cod_trazo=0;
				//OCR.getImagen('default.png');
				Ext.getCmp(OCR.id+'-cbx-tipo-texto').setValue('S');
				Ext.getCmp(OCR.id+'-txt-nombre-trazo').setValue('');
				Ext.getCmp(OCR.id+'-txt-texto-trazo').setValue('');
				Ext.getCmp(OCR.id+'-txt-x').setValue('');
				Ext.getCmp(OCR.id+'-txt-y').setValue('');
				Ext.getCmp(OCR.id+'-txt-w').setValue('');
				Ext.getCmp(OCR.id+'-txt-h').setValue('');
				Ext.getCmp(OCR.id+'-txt-nombre-trazo').focus();
				try{
					document.getElementById('imagen-trazo').src=''
				}catch(err) {
				    console.log(err.message); 
				}
				//OCR.getDropImg();
			},
			recognize_image:function(id){
				document.getElementById(id).innerText = "(Recognizing...)"
				OCRAD(document.getElementById("pic"), {
					numeric: true
				}, function(text){
					
				});
			},
			getDropImg:function(){
				var image = document.getElementById('imagen-plantilla');//document.querySelector('#imagen-plantilla');
		      //var data = document.querySelector('#data');
		      //var canvasData = document.querySelector('#canvasData');
		      //var cropBoxData = document.querySelector('#cropBoxData');
		      try{
			      OCR.cropper = new Cropper(image, {
			      	//dragMode: 'move',
			      	movable: false,
			        zoomable: false,
			        rotatable: false,
			        scalable: false,
			        cropBoxMovable: true,
			        cropBoxResizable: true,
			        ready: function (event) {
			          // Zoom the image to its natural size
			          //OCR.cropper.zoomTo(1);
			          //OCR.cropper.movable();
			          //OCR.cropper.cropBoxMovable();

			          	/*var clone = this.cloneNode();
			          	clone.id='imagen-clonado';
			          	clone.className = '';
			            clone.style.cssText = (
			              'display: block;' +
			              'width: 100%;' +
			              'min-width: 0;' +
			              'min-height: 0;' +
			              'max-width: none;' +
			              'max-height: none;'
			            );
			            document.getElementById('imagen-trazo').appendChild(clone.cloneNode());*/
			        },

			        crop: function (event) {
			          console.log(OCR.cropper.getCropBoxData());
			          OCR.cropperData=OCR.cropper.getCropBoxData()
			          //data.textContent = JSON.stringify(cropper.getData());
			          //cropBoxData.textContent = JSON.stringify(cropper.getCropBoxData());
			          //Ext.getCmp(OCR.id+'-txt-texto-trazo').setValue(JSON.stringify(OCR.cropper.getCropBoxData()));
			          	/*var data = event.detail;
			            var cropper = this.cropper;
			            var imageData = cropper.getImageData();
			            var previewAspectRatio = data.width / data.height;

			            var elem = document.getElementById('imagen-clonado');
			            var previewImage = elem;
		              	var previewWidth = elem.offsetWidth;
		              	var previewHeight = previewWidth / previewAspectRatio;
		              	var imageScaledRatio = data.width / previewWidth;

		              	elem.style.height = previewHeight + 'px';
		              	previewImage.style.width = imageData.naturalWidth / imageScaledRatio + 'px';
		              	previewImage.style.height = imageData.naturalHeight / imageScaledRatio + 'px';
		              	previewImage.style.marginLeft = -data.x / imageScaledRatio + 'px';
		              	previewImage.style.marginTop = -data.y / imageScaledRatio + 'px';*/
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
			load_file:function(panel,id) {
				/*var reader = new FileReader();
				reader.onload = function(){
					var img =document.getElementById('imagen-plantilla');
					//var img = new Image();
					img.src = reader.result;
					img.onload = function(){
						document.getElementById('nose').innerHTML = ''
						document.getElementById('nose').appendChild(img)
						OCRAD(img, function(text){
							//document.getElementById('transcription').className = "done"
							//document.getElementById('transcription').innerText = text;
							Ext.getCmp(OCR.id+'-txt-texto-plantilla').setValue(text);
						})
					}
				}
				reader.readAsDataURL(document.getElementById('picker').files[0])*/
				Ext.getCmp(OCR.id+panel).el.mask('Cargando Texto…', 'x-mask-loading');
				var img =document.getElementById(id);
				if(img!=null){
					OCRAD(img, function(text){
						//document.getElementById('transcription').className = "done"
						//document.getElementById('transcription').innerText = text;
						Ext.getCmp(OCR.id+panel).el.unmask();
						Ext.getCmp(OCR.id+'-txt-texto-plantilla').setValue(text);
						//OCR.getDropImg();
					});
				}else{
					setTimeout(function() { OCR.load_file(panel,id); }, 1000);
				}
			},
			setInfoPlantilla: function(index){//(rec,recA){
				var record=Ext.getCmp(OCR.id + '-grid').getStore().getAt(index);

				Ext.getCmp(OCR.id+'-cbx-cliente').setValue(record.data.shi_codigo);
				Ext.getCmp(OCR.id+'-cbx-contrato').setValue(record.data.fac_cliente);
				Ext.getCmp(OCR.id+'-txt-nombre-plantilla-man').setValue(record.data.nombre);
				Ext.getCmp(OCR.id+'-cbx-formato').setValue(record.data.cod_formato);
				Ext.getCmp(OCR.id+'-cbx-estado-man').setValue(record.data.estado);
				Ext.getCmp(OCR.id+'-txt-imagen-man').setValue(record.data.imgorigen);
				Ext.getCmp(OCR.id+'-txt-texto-plantilla').setValue(record.data.texto);

				OCR.parametros.vp_op='U';
				OCR.cod_plantilla=record.data.cod_plantilla;
			    OCR.parametros.vp_cod_plantilla=record.data.cod_plantilla;
			    OCR.parametros.vp_shi_codigo=record.data.shi_codigo;
			    OCR.parametros.vp_fac_cliente=record.data.fac_cliente;
			    OCR.parametros.vp_nombre=record.data.nombre;
			    OCR.parametros.vp_cod_formato=record.data.cod_formato;
			    OCR.parametros.vp_width=record.data.width;
			    OCR.parametros.vp_height=record.data.height;
			    OCR.parametros.vp_path=record.data.path;
			    OCR.parametros.vp_img=record.data.img;
			    OCR.parametros.vp_pathorigen=record.data.pathorigen;
			    OCR.parametros.vp_imgorigen=record.data.imgorigen;
			    OCR.parametros.vp_texto=record.data.texto;
			    OCR.parametros.vp_estado=record.data.estado;



				var panel = Ext.getCmp(OCR.id+'-panel_img');
                panel.removeAll();
                if(record.data.img!=''){
	                panel.add({
	                    html: '<img id="imagen-plantilla" src="'+record.data.path+record.data.img+'" style="width:100%; height:"100%;overflow: scroll;" />'//style=""
	                });
	                panel.doLayout();
	                /*OCR.getDropImg();
	                if(record.data.texto==''){
	                	OCR.load_file('-panel_texto','imagen-plantilla');
	                }*/
	                var image = document.getElementById('imagen-plantilla');
					var downloadingImage = new Image();
					downloadingImage.onload = function(){
					    image.src = this.src;
					    OCR.getDropImg();
		                if(record.data.texto==''){
		                	OCR.load_file('-panel_texto','imagen-plantilla'); 
		                }
		                Ext.getCmp(OCR.id+'-panel_img').doLayout();
					};
					downloadingImage.src = record.data.path+record.data.img;
					console.log(record.data.path+record.data.img);
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
		        gestor_errores.setInfoPlantilla(rec_01,rec);*/
		    },
		    setLimpiar:function(){
		        /*var panel = Ext.getCmp(gestor_errores.id+'-panel_img');
		        panel.removeAll();        
		        panel.doLayout();*/
		    },
		    getReloadGridlotizer:function(){
				//lotizer.set_lotizer_clear();
				//Ext.getCmp(lotizer.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				var shi_codigo = Ext.getCmp(OCR.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(OCR.id+'-cbx-contrato').getValue();
				var lote = Ext.getCmp(OCR.id+'-txt-lote-page').getValue();
				var name = Ext.getCmp(OCR.id+'-txt-lotizer-page').getValue();
				var estado = 'A';
				var fecha = Ext.getCmp(OCR.id+'-txt-fecha-page').getRawValue();

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
				Ext.getCmp(OCR.id + '-grid-lote').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote:lote,vp_lote_estado:'ES',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(lotizer.id+'-form').el.unmask();
	                }
	            });
			},
			getSizeImgPlantilla:function(callback,imgSrc){
				var newImg = new Image();
			    newImg.onload = function () {
			    	var imgWidth = newImg.width || newImg.naturalWidth;
					var imgHeight = newImg.height || newImg.naturalHeight;
			        if (callback != undefined)callback({width: imgWidth, height: imgHeight})
			    }
			    newImg.src = imgSrc;
			},
			setSizeImgPlantilla:function(json){
				OCR.parametros.vp_width=json.width;
			    OCR.parametros.vp_height=json.height;
			    Ext.getCmp(OCR.id+'-win-form').close();
			},
		    setAsignaImagen:function(index){
		    	var record=OCR.storeTree.getAt(index);
				Ext.getCmp(OCR.id+'-txt-imagen-man').setValue(record.data.img);
				OCR.parametros.vp_pathorigen=record.data.path;
				OCR.parametros.vp_imgorigen=record.data.img;
				OCR.getSizeImgPlantilla(OCR.setSizeImgPlantilla,record.data.nombre);
		    },
		    setNuevoPlantilla:function(){
				Ext.getCmp(OCR.id+'-txt-nombre-plantilla-man').setValue('');
				Ext.getCmp(OCR.id+'-cbx-formato').setValue(1);
				Ext.getCmp(OCR.id+'-cbx-estado-man').setValue('A');
				Ext.getCmp(OCR.id+'-txt-imagen-man').setValue('');
				Ext.getCmp(OCR.id+'-txt-texto-plantilla').setValue('');

		    	OCR.parametros={
					vp_op:'I',
			        vp_cod_plantilla:0,
			        vp_shi_codigo:0,
			        vp_fac_cliente:0,
			        vp_nombre:'',
			        vp_cod_formato:1,
			        vp_width:0,
			        vp_height:0,
			        vp_path:'',
			        vp_img:'',
			        vp_pathorigen:'',
			        vp_imgorigen:'',
			        vp_texto:'',
			        vp_estado:'A'
				};
				OCR.setNuevo();
				Ext.getCmp(OCR.id + '-grid-trazos').getStore().removeAll();
				var panel = Ext.getCmp(OCR.id+'-panel_img');
                panel.removeAll();
                Ext.getCmp(OCR.id+'-txt-nombre-plantilla-man').focus();
		    },
			setPlantillas:function(){
				
				var shi_codigo = Ext.getCmp(OCR.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(OCR.id+'-cbx-contrato').getValue();
				var nombre = Ext.getCmp(OCR.id+'-txt-nombre-plantilla-man').getValue();
				var formato = Ext.getCmp(OCR.id+'-cbx-formato').getValue();
				var estado = Ext.getCmp(OCR.id+'-cbx-estado-man').getValue();
				var imagen = Ext.getCmp(OCR.id+'-txt-imagen-man').getValue();
				var texto = Ext.getCmp(OCR.id+'-txt-texto-plantilla').getValue();

		    	if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(nombre== null || nombre==''){
		            global.Msg({msg:"Ingrese un nombre.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(formato== null || formato==0 || formato==''){
		            global.Msg({msg:"Seleccione un formato.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(estado== null || estado==''){
		            global.Msg({msg:"Seleccione estado.",icon:2,fn:function(){}});
		            return false;
		        }
		        if(imagen== null || imagen==''){
		            global.Msg({msg:"Seleccione Imagen de Página Modelo.",icon:2,fn:function(){}});
		            return false;
		        }

				OCR.parametros.vp_op=(OCR.parametros.vp_cod_plantilla!=0)?'U':'I';
			    OCR.parametros.vp_cod_plantilla=OCR.parametros.vp_cod_plantilla;
			    OCR.parametros.vp_shi_codigo=shi_codigo;
			    OCR.parametros.vp_fac_cliente=fac_cliente;
			    OCR.parametros.vp_nombre=nombre;
			    OCR.parametros.vp_cod_formato=formato;
			    OCR.parametros.vp_width=OCR.parametros.vp_width;
			    OCR.parametros.vp_height=OCR.parametros.vp_height;
			    OCR.parametros.vp_path=OCR.parametros.vp_path;
			    OCR.parametros.vp_img=OCR.parametros.vp_img;
			    OCR.parametros.vp_pathorigen=OCR.parametros.vp_pathorigen;
			    OCR.parametros.vp_imgorigen=imagen;
			    OCR.parametros.vp_texto=texto;
			    OCR.parametros.vp_estado=estado;

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                    	if (btn == 'yes'){
	                        Ext.getCmp(OCR.id+'-form').el.mask('Guardando Formato Plantilla', 'x-mask-loading');
	                        Ext.Ajax.request({
			                    url: OCR.url + 'set_ocr_plantilla/',
			                    params:OCR.parametros,
			                    success: function(response, options){
			                    	Ext.getCmp(OCR.id+'-form').el.unmask(); 
			                        var res = Ext.JSON.decode(response.responseText);
			                        if (res.error == 'OK'){
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 1,
			                                buttons: 1,
			                                fn: function(btn){
			                                	OCR.setNuevoPlantilla();
			                                    OCR.getReloadGridOCR();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: res.msn,
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    //OCR.getReloadGridOCR();
			                                }
			                            });
			                        }
			                    }
			                });
						}
		            }
                });
				
			},
		    getFormPage:function(){
		    	var shi_codigo = Ext.getCmp(OCR.id+'-cbx-cliente').getValue();
				var fac_cliente = Ext.getCmp(OCR.id+'-cbx-contrato').getValue();
		    	if(shi_codigo== null || shi_codigo==''){
		            global.Msg({msg:"Seleccione un Cliente por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				if(fac_cliente== null || fac_cliente==''){
		            global.Msg({msg:"Seleccione un Contrato por favor.",icon:2,fn:function(){}});
		            return false;
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
	                id:OCR.id+'-win-form',
	                plain: true,
	                title:'Buscar Página',
	                icon: '/images/icon/edit.png',
	                height: 400,
	                width: 1000,
	                resizable:false,
	                modal: true,
	                border:false,
	                closable:true,
	                padding:4,
	                layout:'border',
	                items:[
	                	{
	                		region:'east',
	                		border:false,
	                		width:300,
	                		html: '<div id="imagen-page" style="width:100%; height:"100%;overflow: none;" ><img src="/plantillas/Document-Scanning-Indexing-Services-min.jpg" width="100%" height="100%"/></div>'
	                	},
	                	{
	                		region:'center',
	                		layout:'border',
	                		border:false,
	                		items:[
	                			{
		                            region:'north',
		                            border:false,
		                            xtype: 'uePanelS',
		                            logo: 'LT',
		                            title: 'Listado de Páginas',
		                            legend: 'Búsqueda de páginas registradas',
		                            height:90,
		                            width:700,
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
		                                                    id:OCR.id+'-txt-lote-page',
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
		                                            width:200,border:false,
		                                            padding:'0px 2px 0px 0px',  
		                                            bodyStyle: 'background: transparent',
		                                            items:[
		                                                {
		                                                    xtype: 'textfield',	
		                                                    fieldLabel: 'Nombre Lote',
		                                                    id:OCR.id+'-txt-lotizer-page',
		                                                    labelWidth:80,
		                                                    //readOnly:true,
		                                                    labelAlign:'right',
		                                                    width:'100%',
		                                                    anchor:'100%'
		                                                }
		                                            ]
		                                        },
		                                        {
			                                        width: 160,
			                                        border:false,
			                                        padding:'0px 2px 0px 0px',  
			                                    	bodyStyle: 'background: transparent',
			                                        items:[
			                                            {
			                                                xtype:'datefield',
			                                                id:OCR.id+'-txt-fecha-page',
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
									                            	//var name = Ext.getCmp(OCR.id+'-txt-lotizer').getValue();
		                               					            OCR.getReloadGridlotizer();
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
			                        xtype: 'treepanel',
			                        region:'center',
			                        //collapsible: true,
							        useArrows: true,
							        rootVisible: true,
							        multiSelect: true,
							        //root:'Task',
			                        id: OCR.id + '-grid-lote',
			                        //height: 370,
			                        //reserveScrollbar: true,
			                        //rootVisible: false,
			                        //store: store,
			                        //layout:'fit',
			                        columnLines: true,
			                        store: OCR.storeTree,
						            columns: [
							            
							            {
							            	xtype: 'treecolumn',
		                                    text: 'Nombre',
		                                    dataIndex: 'lote_nombre',
		                                    sortable: true,
		                                    flex: 1
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
		                                    text: 'Editar',
		                                    dataIndex: 'estado',
		                                    //loocked : true,
		                                    width: 50,
		                                    align: 'center',
		                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
		                                        //console.log(record);
		                                        if(parseInt(record.get('nivel')) == 3){
			                                        metaData.style = "padding: 0px; margin: 0px";
			                                        return global.permisos({
			                                            type: 'link',
			                                            id_menu: OCR.id_menu,
			                                            icons:[
			                                                {id_serv: 6, img: 'basket_put.png', qtip: 'Click para Editar Lote.', js: "OCR.setAsignaImagen("+rowIndex+")"}
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
											document.getElementById('imagen-page').innerHTML='<img src="'+record.get('nombre')+'" width="100%" height="100%"/>'
										}
			                        }
			                    }
	                		]
	                	}
	                ],
	                bbar:[       
	                    '->',
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
	                                Ext.getCmp(OCR.id+'-win-form').close();
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
		Ext.onReady(OCR.init,OCR);
	}else{
		tab.setActiveTab(OCR.id+'-tab');
	}
</script>