<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('closing-tab')){
		var closing = {
			id:'closing',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/closing/',
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
                    url: closing.url+'get_list/?vp_cod_lote=0',
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
                    url: closing.url+'get_sis_list_shipper_campana/',
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
					id:closing.id+'-form',
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
	                                                        id:closing.id+'-txt-nombre',
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
	                                                        id:closing.id+'-txt-descripcion',
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
	                                                        id:closing.id+'-date-re',
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
	                                                		id:closing.id+'-form-info',
	                                                		border:false,
	                                                		items:[
	                                                			{
														            xtype: 'filefield',
														            emptyText: 'Seleccione una imagen',
														            fieldLabel: 'Imagen',
														            labelAlign:'right',
														            labelWidth:60,
														            name: 'uploadedfile',
														            id:closing.id+'-imagen_closing',
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
                                                        id:closing.id+'-cmb-estado',
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
					                                //closing.buscar_ge();
					                                closing.setclosing();
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
					                                //closing.buscar_ge();
					                                closing.opcion='I';
					                                closing.setNuevo();
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
					                        id: closing.id + '-grid-closing',
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
					                                            id_menu: closing.id_menu,
					                                            icons:[
					                                                {id_serv: 9, img: 'detail.png', qtip: 'Click para ver detalle.', js: 'closing.getFormDetalleGestion()'}
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
	                                                        fieldLabel: 'closing',
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
									                                //closing.buscar_ge();
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
					                        id: closing.id + '-grid',
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
					                                            id_menu: closing.id_menu,
					                                            icons:[
					                                                {id_serv: 9, img: 'detail.png', qtip: 'Click para ver detalle.', js: 'closing.getFormDetalleGestion()'}
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
					                                closing.getImagen('default.png');
					                            },
												beforeselect:function(obj, record, index, eOpts ){
													//console.log(record);
													closing.opcion='U';
													closing.cod_cam=record.get('cod_cam');
													closing.getImagen(record.get('imagen'));
													Ext.getCmp(closing.id+'-txt-nombre').setValue(record.get('nombre'));
													Ext.getCmp(closing.id+'-txt-descripcion').setValue(record.get('descripcion'));
													Ext.getCmp(closing.id+'-date-re').setValue(record.get('fec_crea'));
													Ext.getCmp(closing.id+'-cmb-estado').setValue(record.get('estado'));
													closing.getReloadGridclosing(record.get('cod_cam'));
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
					id:closing.id+'-tab',
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
	                        global.state_item_menu(closing.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,closing.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(closing.id_menu, false);
	                    }
					}

				}).show();
			},
			getImagen:function(param){
				win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/closing/'+param}});
			},
			setclosing:function(op){

				global.Msg({
                    msg: '¿Está seguro de guardar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(closing.id+'-form').el.mask('Cargando…', 'x-mask-loading');

						Ext.getCmp(closing.id+'-form-info').submit({
		                    url: closing.url + 'setRegisterCampana/',
		                    params:{
		                        vp_op: closing.opcion,
		                        vp_shi_codigo:closing.cod_cam,
		                        vp_shi_nombre:Ext.getCmp(closing.id+'-txt-nombre').getValue(),
		                        vp_shi_descripcion:Ext.getCmp(closing.id+'-txt-descripcion').getValue(),
		                        vp_fec_ingreso:Ext.getCmp(closing.id+'-date-re').getRawValue(),
		                        vp_estado:Ext.getCmp(closing.id+'-cmb-estado').getValue()
		                    },
		                    success: function( fp, o ){
		                    	//console.log(o);
		                        var res = o.result;
		                        Ext.getCmp(closing.id+'-form').el.unmask();
		                        //console.log(res);
		                        if (parseInt(res.error) == 0){
		                            global.Msg({
		                                msg: res.data,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
		                                    closing.getReloadGridclosing('');
		                                    closing.setNuevo();
		                                }
		                            });
		                        } else{
		                            global.Msg({
		                                msg: 'Ocurrio un error intentalo nuevamente.',
		                                icon: 0,
		                                buttons: 1,
		                                fn: function(btn){
		                                    closing.getReloadGridclosing('');
		                                    closing.setNuevo();
		                                }
		                            });
		                        }
		                    }
		                });
		            }
                });
			},
			getReloadGridclosing:function(name){
				Ext.getCmp(closing.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				Ext.getCmp(closing.id + '-grid').getStore().load(
	                {params: {vp_nombre:name},
	                callback:function(){
	                	Ext.getCmp(closing.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridclosing:function(campana){
				Ext.getCmp(closing.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				Ext.getCmp(closing.id + '-grid-closing').getStore().load(
	                {params: {campana:campana},
	                callback:function(){
	                	Ext.getCmp(closing.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				closing.shi_codigo=0;
				closing.getImagen('default.png');
				Ext.getCmp(closing.id+'-txt-nombre').setValue('');
				Ext.getCmp(closing.id+'-txt-descripcion').setValue('');
				Ext.getCmp(closing.id+'-date-re').setValue('');
				Ext.getCmp(closing.id+'-cmb-estado').setValue('');
				Ext.getCmp(closing.id+'-txt-nombre').focus();
			}
		}
		Ext.onReady(closing.init,closing);
	}else{
		tab.setActiveTab(closing.id+'-tab');
	}
</script>