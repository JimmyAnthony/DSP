<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('OCR-tab')){
		var OCR = {
			id:'OCR',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/OCR/',
			opcion:'I',
			init:function(){
				var store = Ext.create('Ext.data.Store',{
                fields: [
                    {name: 'cod_lote', type: 'string'},
                    {name: 'lote', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'usuario', type: 'string'},
                    {name: 'cantidad', type: 'string'}
                ],
                autoLoad:true,
                proxy:{
                    type: 'ajax',
                    url: OCR.url+'get_list/?vp_cod_lote=0',
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
                    url: OCR.url+'get_sis_list_shipper_campana/',
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
					layout:'border',
					defaults:{
						border:false
					},
					tbar:[],
					items:[
						{
							region:'east',
							border:true,
							width:'30%',
							padding:'5px 5px 5px 5px',
							layout:'border',
							items:[
								{
									region:'north',
									border:false,
									items:[
										{
	                                        xtype: 'fieldset',
	                                        margin: '5 5 5 10',
	                                        title:'<b>Mantenimiento de Lotizador</b>',
	                                        border:false,
	                                        bodyStyle: 'background: transparent',
	                                        padding:'2px 5px 1px 5px',
	                                        layout:'column',
	                                        items: [
	                                            {
	                                                columnWidth: 1,border:false,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'Nombre',
	                                                        id:OCR.id+'-txt-nombre',
	                                                        labelWidth:60,
	                                                        //readOnly:true,
	                                                        labelAlign:'right',
	                                                        width:'100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            {
	                                                columnWidth: 1,border:false,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'Descripcion',
	                                                        id:OCR.id+'-txt-descripcion',
	                                                        labelWidth:60,
	                                                        //readOnly:true,
	                                                        labelAlign:'right',
	                                                        width:'100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            {
	                                                columnWidth: 0.40,border:false,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype:'datefield',
	                                                        id:OCR.id+'-date-re',
	                                                        fieldLabel:'Fecha',
	                                                        labelWidth:60,
	                                                        labelAlign:'right',
	                                                        value:new Date('Y-m-d'),
	                                                        format: 'Y-m-d',
	                                                        width: '100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            {
	                                                columnWidth: 1,border:false,
	                                                padding:'10px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                	{
	                                                		xtype:'form',
	                                                		id:OCR.id+'-form-info',
	                                                		border:false,
	                                                		items:[
	                                                			{
														            xtype: 'filefield',
														            emptyText: 'Seleccione una imagen',
														            fieldLabel: 'Imagen',
														            labelAlign:'right',
														            labelWidth:60,
														            name: 'uploadedfile',
														            id:OCR.id+'-imagen_OCR',
														            buttonText: '',
														            width: '100%',
	                                                        		anchor:'100%',
														            buttonConfig: {
														                icon: '/images/icon/upload-file.png',
														            }
														        }
	                                                		]
	                                                	}
	                                                ]
	                                            },
	                                            {
	                                                columnWidth: 1,border:false,
	                                                padding:'0px 2px 0px 0px',  bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                    	xtype:'panel',
	                                                    	padding:'10px 60px 10px 60px',
	                                                    	border:true,
	                                                    	height:300,
	                                                    	html:'<div id="GaleryFull" class="links"></div>'
	                                                    }
	                                                ]
	                                            },
	                                            {
                                                columnWidth: 0.50,border:false,
                                                padding:'0px 2px 0px 0px',  bodyStyle: 'background: transparent',
                                                items:[
                                                    {
                                                        xtype:'combo',
                                                        fieldLabel: 'Estado',
                                                        id:OCR.id+'-cmb-estado',
                                                        store: store_estado,
                                                        queryMode: 'local',
                                                        triggerAction: 'all',
                                                        valueField: 'code',
                                                        displayField: 'name',
                                                        emptyText: '[Seleccione]',
                                                        labelAlign:'right',
                                                        //allowBlank: false,
                                                        labelWidth: 80,
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
	                                        ]
	                                    }
									],
									bbar:[
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
					                                //OCR.buscar_ge();
					                                OCR.setOCR();
					                            }
					                        }
					                    },
					                    {
					                        xtype:'button',
					                        text: 'Nuevo',
					                        icon: '/images/icon/file.png',
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
					                                //OCR.buscar_ge();
					                                OCR.opcion='I';
					                                OCR.setNuevo();
					                            }
					                        }
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
					                        id: OCR.id + '-grid-OCR',
					                        store: store_shipper,
					                        columnLines: true,
					                        columns:{
					                            items:[
					                                {
					                                    text: 'Shipper',
					                                    dataIndex: 'shi_nombre',
					                                    flex: 1
					                                },
					                                {
					                                    text: 'Estado',
					                                    dataIndex: 'shi_estado',
					                                    width: 100,
					                                    align: 'center',
					                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
					                                        return value==1?'Activo':'Inactivo';
					                                    }
					                                }/*,
					                                {
					                                    text: 'Logo',
					                                    dataIndex: 'shi_logo',
					                                    width: 150
					                                },
					                                {
					                                    text: 'Estado',
					                                    dataIndex: 'shi_estado',
					                                    width: 100,
					                                    align: 'center',
					                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
					                                        return value==1?'Activo':'Inactivo';
					                                    }
					                                },
					                                {
					                                    text: '&nbsp;',
					                                    dataIndex: '',
					                                    width: 30,
					                                    align: 'center',
					                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
					                                        metaData.style = "padding: 0px; margin: 0px";
					                                        return global.permisos({
					                                            type: 'link',
					                                            id_menu: OCR.id_menu,
					                                            icons:[
					                                                {id_serv: 9, img: 'detail.png', qtip: 'Click para ver detalle.', js: 'OCR.getFormDetalleGestion()'}
					                                            ]
					                                        });
					                                    }
					                                }*/
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
							//layout:'fit',
							items:[
								{
	                                //region:'north',
	                                border:false,
	                                xtype: 'uePanelS',
	                                logo: 'CL',
	                                title: 'Listado de Lotizador',
	                                legend: 'Búsqueda de Lotes registradas',
	                                height:100,
	                                items:[
	                                    {
	                                        xtype:'panel',
	                                        border:false,
	                                        bodyStyle: 'background: transparent',
	                                        padding:'2px 5px 1px 5px',
	                                        layout:'column',
	                                        items: [
	                                            {
	                                                width:600,border:false,
	                                                padding:'0px 2px 0px 0px',  
	                                                bodyStyle: 'background: transparent',
	                                                items:[
	                                                    {
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'OCR',
	                                                        id:OCR.id+'-txt-OCR',
	                                                        labelWidth:80,
	                                                        //readOnly:true,
	                                                        labelAlign:'right',
	                                                        width:'100%',
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
									                                //OCR.buscar_ge();
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
									//region:'center',
									width:'100%',
									layout:'fit',
									items:[
										{
					                        xtype: 'grid',
					                        id: OCR.id + '-grid',
					                        store: store,
					                        layout:'fit',
					                        columnLines: true,
					                        columns:{
					                            items:[
					                                {
					                                    text: 'Cod.Lote',
					                                    dataIndex: 'cod_lote',
					                                    width: 150
					                                },
					                                {
					                                    text: 'Lote',
					                                    dataIndex: 'lote',
					                                    flex: 1
					                                },
					                                {
					                                    text: 'Fecha',
					                                    dataIndex: 'fecha',
					                                    width: 150
					                                },
					                                {
					                                    text: 'Usuario',
					                                    dataIndex: 'usuario',
					                                    width: 100
					                                },
					                                {
					                                    text: 'Cantidad',
					                                    dataIndex: 'cantidad',
					                                    width: 100,
					                                    align: 'center',
					                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
					                                        return value==1?'Activo':'Inactivo';
					                                    }
					                                },
					                                {
					                                    text: '&nbsp;',
					                                    dataIndex: '',
					                                    width: 30,
					                                    align: 'center',
					                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view){
					                                        metaData.style = "padding: 0px; margin: 0px";
					                                        return global.permisos({
					                                            type: 'link',
					                                            id_menu: OCR.id_menu,
					                                            icons:[
					                                                {id_serv: 9, img: 'detail.png', qtip: 'Click para ver detalle.', js: 'OCR.getFormDetalleGestion()'}
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
					                                OCR.getImagen('default.png');
					                            },
												beforeselect:function(obj, record, index, eOpts ){
													//console.log(record);
													OCR.opcion='U';
													OCR.cod_cam=record.get('cod_cam');
													OCR.getImagen(record.get('imagen'));
													Ext.getCmp(OCR.id+'-txt-nombre').setValue(record.get('nombre'));
													Ext.getCmp(OCR.id+'-txt-descripcion').setValue(record.get('descripcion'));
													Ext.getCmp(OCR.id+'-date-re').setValue(record.get('fec_crea'));
													Ext.getCmp(OCR.id+'-cmb-estado').setValue(record.get('estado'));
													OCR.getReloadGridOCR(record.get('cod_cam'));
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
						type:'fit'
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
			getImagen:function(param){
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/OCR/'+param}});
			},
			setOCR:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
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
                });
			},
			getReloadGridOCR:function(name){
				Ext.getCmp(OCR.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				Ext.getCmp(OCR.id + '-grid').getStore().load(
	                {params: {vp_nombre:name},
	                callback:function(){
	                	Ext.getCmp(OCR.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridOCR:function(campana){
				Ext.getCmp(OCR.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				Ext.getCmp(OCR.id + '-grid-OCR').getStore().load(
	                {params: {campana:campana},
	                callback:function(){
	                	Ext.getCmp(OCR.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				OCR.shi_codigo=0;
				OCR.getImagen('default.png');
				Ext.getCmp(OCR.id+'-txt-nombre').setValue('');
				Ext.getCmp(OCR.id+'-txt-descripcion').setValue('');
				Ext.getCmp(OCR.id+'-date-re').setValue('');
				Ext.getCmp(OCR.id+'-cmb-estado').setValue('');
				Ext.getCmp(OCR.id+'-txt-nombre').focus();
			}
		}
		Ext.onReady(OCR.init,OCR);
	}else{
		tab.setActiveTab(OCR.id+'-tab');
	}
</script>