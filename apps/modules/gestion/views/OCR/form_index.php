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
			init:function(){
				Ext.tip.QuickTipManager.init();

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
									                            	var name = Ext.getCmp(OCR.id+'-txt-OCR').getValue();
		                               					            OCR.getReloadGridOCR(name);
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
					                                    width: 60
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
													OCR.getReloadGridOCRTRAZOS(record.get('cod_plantilla'));
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
							autoScroll:true,
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
									padding:'5px 5px 5px 5px'
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
                       					            OCR.getSizeImg('/scanning/escaneado.jpg',op,OCR.cropper.getCropBoxData(),OCR.getResizeOrigin);
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
		                                        },
											]
										},
										{
											region:'center',
											bodyStyle: 'background: transparent',
											id: OCR.id + '-panel-img-trazos',
											border:true,
											html: '<div id="imagen-trazo" style="width:100%; height:"100%;overflow: none;" ><canvas id="canvas"></canvas></div>'
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
					                                                {id_serv: 1, img: estado, qtip: qtip, js: ""}
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
	                        OCR.getImg_tiff('escaneado');
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
			setOCRTrazos:function(res){
				//var res = Ext.JSON.decode(name);
				console.log(res);
				var tipo = Ext.getCmp(OCR.id+'-cbx-tipo-texto').getValue();
				var nombre = Ext.getCmp(OCR.id+'-txt-nombre-trazo').getValue();
				var texto = Ext.getCmp(OCR.id+'-txt-texto-trazo').getValue();
				//OCR.cod_trazo=record.data.cod_trazo;
				//OCR.cod_plantilla=record.data.cod_plantilla;
				/*Ext.getCmp(OCR.id+'-txt-x').getValue();
				Ext.getCmp(OCR.id+'-txt-y').getValue();
				Ext.getCmp(OCR.id+'-txt-w').getValue();
				Ext.getCmp(OCR.id+'-txt-h').getValue();*/

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(OCR.id+'-panel-trazos-form').el.mask('Cargando…', 'x-mask-loading');
                        Ext.Ajax.request({
		                    url: OCR.url + 'set_ocr_trazos/',
		                    params:{
		                    	vp_op:res.op,
						        vp_cod_trazo:OCR.cod_trazo,
						        vp_cod_plantilla:OCR.cod_plantilla, 
						        vp_nombre:nombre,
						        vp_tipo:tipo,
						        vp_y:res.top,
						        vp_x:res.left,
						        vp_w:res.width,
						        vp_h:res.height,
						        vp_path:'',
						        vp_img:'',
						        vp_texto:texto,
						        vp_estado:'A'
		                    },
		                    success: function(response, options){
		                    	Ext.getCmp(OCR.id+'-panel-trazos-form').el.unmask(); 
		                        var res = Ext.JSON.decode(response.responseText);
		                        if (res.error == 'OK'){
		                            global.Msg({
		                                msg: res.msn,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
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
			                                    OCR.getReloadGridOCR('');
			                                    OCR.setNuevo();
			                                }
			                            });
			                        } else{
			                            global.Msg({
			                                msg: 'Ocurrio un error intentalo nuevamente.',
			                                icon: 0,
			                                buttons: 1,
			                                fn: function(btn){
			                                    OCR.getReloadGridOCR('');
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
				Ext.getCmp(OCR.id+'-cbx-tipo-texto').setValue(record.data.tipo);
				Ext.getCmp(OCR.id+'-txt-nombre-trazo').setValue(record.data.nombre);
				Ext.getCmp(OCR.id+'-txt-texto-trazo').setValue(record.data.texto);
				Ext.getCmp(OCR.id+'-txt-x').setValue(record.data.x);
				Ext.getCmp(OCR.id+'-txt-y').setValue(record.data.y);
				Ext.getCmp(OCR.id+'-txt-w').setValue(record.data.w);
				Ext.getCmp(OCR.id+'-txt-h').setValue(record.data.h);
				OCR.getSizeImg('/scanning/escaneado.jpg','S',{left:record.data.x,top:record.data.y,width:record.data.w,height:record.data.h},OCR.getResizeOrigin);
			},
			getResizeOrigin:function(op,jsona,jsonb){
				var container=OCR.cropper.getContainerData()
				var wa = jsona.width /  parseFloat(container.width);
				var wb = jsona.height / parseFloat(container.height);
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
			        if (callback != undefined)callback(op,{width: newImg.width, height: newImg.height},json)
			    }
			    newImg.src = imgSrc;
			},
			getReloadGridOCR:function(name){
				//OCR.set_OCR_clear();
				//Ext.getCmp(OCR.id+'-form').el.mask('Cargando…', 'x-mask-loading');
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
				if(fecha== null || fecha==''){
		            global.Msg({msg:"Ingrese una fecha de busqueda por favor.",icon:2,fn:function(){}});
		            return false;
		        }
				Ext.getCmp(OCR.id + '-grid').getStore().load(
	                {params: {vp_shi_codigo:shi_codigo,vp_fac_cliente:fac_cliente,vp_lote_estado:'LT',vp_name:name,fecha:fecha,vp_estado:estado},
	                callback:function(){
	                	//Ext.getCmp(OCR.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridOCRTRAZOS:function(id){
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
		      OCR.cropper = new Cropper(image, {
		      	//dragMode: 'move',
		      	movable: false,
		        zoomable: false,
		        rotatable: false,
		        scalable: false,
		        cropBoxMovable: true,
		        cropBoxResizable: false,
		        ready: function (event) {
		          // Zoom the image to its natural size
		          //OCR.cropper.zoomTo(1);
		          //OCR.cropper.movable();
		          //OCR.cropper.cropBoxMovable();

		          	var clone = this.cloneNode();
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
		            document.getElementById('imagen-trazo').appendChild(clone.cloneNode());
		        },

		        crop: function (event) {
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
						OCR.getDropImg();
					});
				}else{
					setTimeout(function() { OCR.load_file(panel,id); }, 1000);
				}
			},
			getImg_tiff: function(file){//(rec,recA){
				
				var panel = Ext.getCmp(OCR.id+'-panel_img');
                panel.removeAll();
                panel.add({
                    html: '<img id="imagen-plantilla" src="/scanning/'+file+'.jpg" style="width:100%; height:"100%;overflow: scroll;" >'//style=""
                });
                panel.doLayout();
                OCR.load_file('-panel_texto','imagen-plantilla');
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
		Ext.onReady(OCR.init,OCR);
	}else{
		tab.setActiveTab(OCR.id+'-tab');
	}
</script>