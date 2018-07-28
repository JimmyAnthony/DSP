<script type="text/javascript">
	var tab = Ext.getCmp(inicio.id+'-tabContent');
	if(!Ext.getCmp('lotizer-tab')){
		var lotizer = {
			id:'lotizer',
			id_menu:'<?php echo $p["id_menu"];?>',
			url:'/gestion/lotizer/',
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
                autoLoad:false,
                proxy:{
                    type: 'ajax',
                    url: lotizer.url+'get_list_lotizer/',
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
                    {name: 'lote', type: 'string'},
                    {name: 'paquete', type: 'string'},
                    {name: 'cod_paquete', type: 'string'},
                    {name: 'fecha', type: 'string'},
                    {name: 'usuario', type: 'string'},
                    {name: 'ctdad_docs', type: 'string'}
                ],
                autoLoad:true,
                proxy:{
                    type: 'ajax',
                    url: lotizer.url+'get_lotizer_detalle/',
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
					id:lotizer.id+'-form',
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
							width:'50%',
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
	                                        title:'<b>Mantenimiento Lotizador</b>',
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
	                                                        fieldLabel: 'Lote',
	                                                        id:lotizer.id+'-txt-nombre',
	                                                        labelWidth:60,
	                                                        readOnly:true,
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
	                                                        id:lotizer.id+'-txt-fecha',
	                                                        fieldLabel:'Fecha',
	                                                        labelWidth:60,
	                                                        labelAlign:'right',
	                                                        value:new Date('Y-m-d'),
	                                                        format: 'Y-m-d',
	                                                        readOnly:true,
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
	                                                        xtype: 'textfield',
	                                                        fieldLabel: 'Usuario',
	                                                        id:lotizer.id+'-txt-usuario',
	                                                        labelWidth:60,
	                                                        readOnly:true,
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
	                                                        fieldLabel: 'Cantidad',
	                                                        id:lotizer.id+'-txt-ctdad',
	                                                        labelWidth:60,
	                                                        readOnly:true,
	                                                        labelAlign:'right',
	                                                        maskRe: /[0-9.]/,
	                                                        width:'100%',
	                                                        anchor:'100%'
	                                                    }
	                                                ]
	                                            },
	                                            
	                                        ]
	                                    }
									],
									bbar:[
										{
											id: 'boton', 
					                        xtype:'button',
					                        text: 'Editar',
					                        icon: '/images/icon/editar.png',
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


													Ext.getCmp(lotizer.id+'-txt-nombre').setReadOnly(false);
													Ext.getCmp(lotizer.id+'-txt-fecha').setReadOnly(false);
												  	Ext.getCmp(lotizer.id+'-txt-ctdad').setReadOnly(false);
													Ext.getCmp(lotizer.id+'-txt-usuario').setReadOnly(true);


													var botonTxt = Ext.getCmp('boton').getText();
													if (botonTxt == 'Editar') {
														Ext.getCmp('boton').setText('Update');
														Ext.getCmp('boton').setIcon('/images/icon/save.png');
													} else {
														Ext.getCmp('boton').setText('Editar');
														Ext.getCmp('boton').setIcon('/images/icon/editar.png');
														if (botonTxt == 'Update') {
															 lotizer.opcion='U';
															// lotizer.setlotizer();
														} else {
															 lotizer.cod_lote = 0;
															 lotizer.opcion='I';
															 lotizer.setlotizer();
														}
													}

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
					                                //lotizer.buscar_ge();
					                                lotizer.opcion='I';

													Ext.getCmp('boton').setText('Grabar');
													Ext.getCmp('boton').setIcon('/images/icon/save.png');

					                                lotizer.cod_lote=0;
													lotizer.getReloadGridlotizer2(lotizer.cod_lote);
					                                lotizer.setNuevo();
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
					                        id: lotizer.id + '-grid-lotizer',
					                        store: store_shipper,
					                        columnLines: true,
					                        columns:{
					                            items:[
					                                {                                	
					                                    text: 'Lote',
					                                    dataIndex: 'lote',
					                                    width: 50
					                                },

					                                {			                                
					                                    text: 'Paquete',
					                                    dataIndex: 'paquete',
					                                    flex: 1
					                                },
					                                {
					                                    text: 'Cod_Paquete',
					                                    dataIndex: 'cod_paquete',
					                                    width: 50
					                                },
					                                {
					                                    text: 'Fecha',
					                                    dataIndex: 'fecha',
					                                    width: 100
					                                },
					                                {
					                                    text: 'Usuario',
					                                    dataIndex: 'usuario',
					                                    width: 100
					                                },
					                                {
					                                    text: 'Ctdad_docs',
					                                    dataIndex: 'ctdad_docs',
					                                    width: 100
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

											beforeselect:function(obj, record, index, eOpts ){
												/*
															Ext.getCmp(lotizer.id+'-txt-nombre').setValue(record.get('lote'));
															Ext.getCmp(lotizer.id+'-txt-descripcion').setValue(record.get('paquete'));
															Ext.getCmp(lotizer.id+'-date-re').setValue(record.get('fecha'));
															Ext.getCmp(lotizer.id+'-txt-qdocs').setValue(record.get('ctdad_docs'));

												*/
														},


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
	                                                        fieldLabel: 'Lotes',
	                                                        id:lotizer.id+'-txt-lotizer',
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
									                            	var name = Ext.getCmp(lotizer.id+'-txt-lotizer').getValue();
		                               					            lotizer.getReloadGridlotizer(name);
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
					                        id: lotizer.id + '-grid',
					                        store: store,
					                        layout:'fit',
					                        columnLines: true,
					                        columns:{
					                            items:[
					                                {
					                                	id: lotizer.id + '-grid-cod_lote',
					                                    text: 'Cod.Lote',
					                                    dataIndex: 'cod_lote',
					                                    width: 50
					                                },
					                                {
					                                	id: lotizer.id + '-grid-lote',
					                                    text: 'Lote',
					                                    dataIndex: 'lote',
					                                    flex: 1
					                                },
					                                {
					                                	id: lotizer.id + '-grid-fecha',
					                                    text: 'Fecha',
					                                    dataIndex: 'fecha',
					                                    width: 150
					                                },
					                                {
					                                	id: lotizer.id + '-grid-usuario',
					                                    text: 'Usuario',
					                                    dataIndex: 'usuario',
					                                    width: 100
					                                },
					                                {
					                                	id: lotizer.id + '-grid-cantidad',
					                                    text: 'Cantidad',
					                                    dataIndex: 'cantidad',
					                                    loocked : true,
					                                    width: 100,
					                                },
					                                
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
					                                lotizer.getImagen('default.png');
					                            },
												beforeselect:function(obj, record, index, eOpts ){
													//console.log(record);
													/*lotizer.opcion='U';*/
													lotizer.cod_lote=record.get('cod_lote');
													/*lotizer.getImagen(record.get('imagen'));*/
													Ext.getCmp(lotizer.id+'-txt-nombre').setValue(record.get('lote'));
													Ext.getCmp(lotizer.id+'-txt-fecha').setValue(record.get('fecha'));
													Ext.getCmp(lotizer.id+'-txt-usuario').setValue(record.get('usuario'));
													Ext.getCmp(lotizer.id+'-txt-ctdad').setValue(record.get('cantidad'));

													Ext.getCmp(lotizer.id+'-txt-nombre').setReadOnly(true);
													Ext.getCmp(lotizer.id+'-txt-fecha').setReadOnly(true);
													Ext.getCmp(lotizer.id+'-txt-ctdad').setReadOnly(true);
													Ext.getCmp(lotizer.id+'-txt-usuario').setReadOnly(true);


													var botonTxt = Ext.getCmp('boton').getText();
													if (botonTxt == 'Guardar' || botonTxt == 'Update') {
														Ext.getCmp('boton').setText('Editar');
														Ext.getCmp('boton').setIcon('/images/icon/editar.png');
													}

													lotizer.getReloadGridlotizer2(lotizer.cod_lote);

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
					id:lotizer.id+'-tab',
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
	                        global.state_item_menu(lotizer.id_menu, true);
	                    },
	                    afterrender: function(obj, e){
	                    	lotizer.getReloadGridlotizer('');
	                        tab.setActiveTab(obj);
	                        global.state_item_menu_config(obj,lotizer.id_menu);
	                    },
	                    beforeclose:function(obj,opts){
	                    	global.state_item_menu(lotizer.id_menu, false);
	                    }
					}

				}).show();
			},
			getImagen:function(param){
				/*win.getGalery({container:'GaleryFull',width:390,height:250,params:{forma:'F',img_path:'/lotizer/'+param}});*/
			},
			setlotizer:function(op){

				global.Msg({
                    msg: '¿Está seguro de salvar?',
                    icon: 3,
                    buttons: 3,
                    fn: function(btn){
                        Ext.getCmp(lotizer.id+'-form').el.mask('Cargando…', 'x-mask-loading');

						Ext.getCmp(lotizer.id+'-form').submit({
		                    url: lotizer.url + 'setRegisterLotizer/',
		                    params:{
		                        vp_op: lotizer.opcion,
		                        vp_cod_lote:lotizer.cod_lote,
		                        vp_lote_nombre:Ext.getCmp(lotizer.id+'-txt-nombre').getValue(),
		                        vp_lote_fecha:Ext.getCmp(lotizer.id+'-txt-fecha').getValue(),
		                        vp_lote_ctdad:Ext.getCmp(lotizer.id+'-txt-ctdad').getValue(),
		                        vp_usuario:Ext.getCmp(lotizer.id+'-txt-usuario').getValue()
		                    },
		                    success: function( fp, o ){
		                    	//console.log(o);
		                        var res = o.result;
		                        
		                        Ext.getCmp(lotizer.id+'-form').el.unmask();
		                        //console.log(res);
		                        if (parseInt(res.error) == 0){
		                            global.Msg({
		                                msg: res.data,
		                                icon: 1,
		                                buttons: 1,
		                                fn: function(btn){
		                                    lotizer.getReloadGridlotizer('');
		                                    lotizer.setNuevo();
		                                }
		                            });
		                        } else{
		                            global.Msg({
		                                msg: 'Ocurrio un error intentalo nuevamente.',
		                                icon: 0,
		                                buttons: 1,
		                                fn: function(btn){
		                                    lotizer.getReloadGridlotizer('');
		                                    lotizer.setNuevo();
		                                }
		                            });
		                        }
		                    }
		                });
		            }
                });
			},
			getReloadGridlotizer:function(name){
				Ext.getCmp(lotizer.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				Ext.getCmp(lotizer.id + '-grid').getStore().load(
	                {params: {vp_name:name},
	                callback:function(){
	                	Ext.getCmp(lotizer.id+'-form').el.unmask();
	                }
	            });
			},
			getReloadGridlotizer2:function(cod_lote){
				Ext.getCmp(lotizer.id+'-form').el.mask('Cargando…', 'x-mask-loading');
				//id:lotizer.id+'-form'
				Ext.getCmp(lotizer.id + '-grid-lotizer').getStore().load(
	                {params: {vp_cod_lote:cod_lote},
	                callback:function(){
	                	Ext.getCmp(lotizer.id+'-form').el.unmask();
	                }
	            });
			},
			setNuevo:function(){
				lotizer.shi_codigo=0;
				//lotizer.getImagen('default.png');
				Ext.getCmp('boton').setText('Guardar');
//					                        icon: '/images/icon/save.png',

				Ext.getCmp(lotizer.id+'-txt-nombre').setValue('');
				Ext.getCmp(lotizer.id+'-txt-nombre').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-fecha').setValue('');
				Ext.getCmp(lotizer.id+'-txt-fecha').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-ctdad').setValue('');
				Ext.getCmp(lotizer.id+'-txt-ctdad').setReadOnly(false);
				Ext.getCmp(lotizer.id+'-txt-usuario').setValue('');
				Ext.getCmp(lotizer.id+'-txt-usuario').setReadOnly(true);
				Ext.getCmp(lotizer.id+'-txt-nombre').focus();
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
	                id:lotizer.id+'-win-form',
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
	                        id:lotizer.id+'-grid-lotizer-form',
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
	                        id:lotizer.id+'-form-descripcion',
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
		Ext.onReady(lotizer.init,lotizer);
	}else{
		tab.setActiveTab(lotizer.id+'-tab');
	}
</script>