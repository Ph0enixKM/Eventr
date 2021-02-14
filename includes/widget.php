<?php

class Eventr_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'eventr_widget', // Base ID
			esc_html__( 'Eventr', 'eventr_domain' ), // Name
			array( 'description' => esc_html__( 'Create an event', 'eventr_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$enroll = get_option('eventr_enroll_lang');
		$back = get_option('eventr_back_lang');
		$mail = get_option('eventr_mail_lang');
		$target = get_option('eventr_email_target');
		$submission = get_option('eventr_submission_lang');

		$icons = new EventrIcons();

		?>

		<div class="eventr-cont">
			<div class="eventr-front" style="
				background-color: <?php echo $instance['bg']; ?>;
				color: <?php echo $instance['fg']; ?>;
			">
				<div class="eventr-title" style="
					background-color: <?php echo $instance['fg']; ?>;
					color: <?php echo $instance['bg']; ?>;
				"><?php echo $instance['title'] ?><div class="eventr-date"><?php echo $instance['date'] ?></div></div>
				<div class="eventr-image" style="
					background-image: url('<?php echo $instance['image']; ?>');
				"></div>
				<div class="eventr-description" ><?php echo nl2br($instance['description']) ?></div>
				<div class="eventr-enroll eventr-btn" style="
					border-color: <?php echo $instance['fg']; ?>;
				"><?php echo $enroll == null ? 'Enroll' : $enroll ?></div>
			</div>
			<div class="eventr-back" style="
				background-color: <?php echo $instance['bg']; ?>;
				color: <?php echo $instance['fg']; ?>;
			">
				<div class="eventr-title" style="
					color: <?php echo $instance['fg']; ?>;
				"><?php echo $instance['title'] ?></div>
				<form>
					<script>
						if (!window.eventr) window.eventr = { }
						window.eventr.text = {
							mail: '<?php echo $mail == null ? 'New person applied to' : $mail ?>',
							target: btoa('<?php echo $target == null ? 'BAD' : $target ?>'),
							submission: '<?php echo $submission == null ? 'Submission sent' : $submission ?>'
						}
						window.eventr.icons = {
							okay: `<?php echo $icons->okay('white'); ?>`.trim()
						}
					</script>
					<input class="eventr-input" type="hidden" name="_title" value="<?php echo esc_attr($instance['title']) ?>"/>

					<?php
						foreach (json_decode($instance['form'], true) as $item) {
							if ($item['type'] === 'checkbox') {
								?>
									<label style="vertical-align: middle">
										<?php echo $item['title'].($item['req'] ? '<span style="color:red">*</span>' : ''); ?>
									</label>
									<input
										class="eventr-input eventr-checkbox <?php echo $item['req'] ? 'eventr-req' : '' ?>"
										type="<?php echo esc_attr($item['type']) ?>"
										name="<?php echo esc_attr($item['title']) ?>"
									/>
									<br/>
								<?php
							}
							else if ($item['type'] === 'select') {
								?>
									<label style="vertical-align: middle">
										<?php echo $item['title'].($item['req'] ? '<span style="color:red">*</span>' : ''); ?>
									</label>
									<select
										class="eventr-input eventr-select <?php echo $item['req'] ? 'eventr-req' : '' ?>"
										name="<?php echo esc_attr($item['title']) ?>"
									>
										<?php
											foreach ($item['options'] as $op) {
												echo "<option value='$op'>$op</option>";
											}
										?>
									</select>
								<?php
							}
							else if ($item['type'] === 'paragraph') {
								?>
									<label style="vertical-align: middle">
										<?php echo $item['title'].($item['req'] ? '<span style="color:red">*</span>' : ''); ?>
									</label>
									<textarea
										class="eventr-input <?php echo $item['req'] ? 'eventr-req' : '' ?>"
										name="<?php echo esc_attr($item['title']) ?>"
									></textarea>
								<?php
							}
							else {
								?>
									<label style="vertical-align: middle">
										<?php echo $item['title'].($item['req'] ? '<span style="color:red">*</span>' : ''); ?>
									</label>
									<input
										class="eventr-input <?php echo $item['req'] ? 'eventr-req' : '' ?>"
										type="<?php echo esc_attr($item['type']) ?>"
										name="<?php echo esc_attr($item['title']) ?>"
										placeholder="<?php echo ((strlen($item['title']) > 35) 
											? esc_attr(substr($item['title'],0,33)).'...' 
											: esc_attr($item['title'])); 
										?>"
									/>
								<?php
							}
						}
					?>

				</form>
				<!-- Enroll -->
				<div class="eventr-submit eventr-btn" style="
					border-color: <?php echo $instance['fg']; ?>;
					color: <?php echo $instance['fg']; ?>;
				">
					<?php echo $enroll == null ? 'Enroll' : $enroll ?>
				</div>
				<!-- Back -->
				<div class="eventr-exit eventr-btn">
					<?php echo $back == null ? 'Back' : $back ?>
				</div>
			</div>
		</div>

		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Eventr', 'eventr_domain' );
		$description = ! empty( $instance['description'] ) ? $instance['description'] : esc_html__( 'Input description here', 'eventr_domain' );
		$image = ! empty( $instance['image'] ) ? $instance['image'] : '';
		$fg = ! empty( $instance['fg'] ) ? $instance['fg'] : '#222222';
		$bg = ! empty( $instance['bg'] ) ? $instance['bg'] : '#dddddd';
		$date = ! empty( $instance['date'] ) ? $instance['date'] : '';
		$form = ! empty( $instance['form'] ) ? $instance['form'] : '{}';

		?>


		<!-- Title -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_attr_e( 'Title:', 'eventr_domain' ); ?>
            </label>
            <input
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                type="text"
				placeholder="Title"
                value="<?php echo esc_attr( $title ); ?>"
            />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
                <?php esc_attr_e( 'Image:', 'eventr_domain' ); ?>
            </label>
			<div
				class="<?php echo esc_attr($this->get_field_id( 'image' )); ?>"
				style="background-image: url('<?php echo esc_attr( $image ); ?>')"
				value="<?php echo esc_attr( $image ); ?>"
			>
			<input
				type="hidden"
				id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>"
				value="<?php echo esc_attr( $image ); ?>"
			/>
				<?php
					echo trim($instance['image']) == ''
						? '<span id="eventr-center">Select image</span>'
						: '<span id="eventr-bin">Delete</span>'
				?>
			</div>
			<style>
				.<?php echo esc_attr($this->get_field_id( 'image' )); ?> {
					width: 100%;
					height: 100px;
					background: #ddd;
					cursor: pointer;
					background-size: cover;
					position: relative;
				}
				.<?php echo esc_attr($this->get_field_id( 'image' )); ?>:hover {
					opacity: 0.9;
				}
				.<?php echo esc_attr($this->get_field_id( 'image' )); ?> #eventr-center {
					display: inline-block;
					position: relative;
					left: 50%;
					top: 50%;
					transform: translate(-50%, -50%);
				}

				.<?php echo esc_attr($this->get_field_id( 'image' )); ?> #eventr-bin {
					display: inline-block;
					position: absolute;
					right: 10px;
					top: 10px;
					padding: 5px;
					background-color: rgba(200, 200, 200, 0.5);
					backdrop-filter: blur(10px);
					border-radius: 10px;
				}
			</style>

			<script>
				jQuery(document).ready(function ($) {
					const selector = '<?php echo esc_attr($this->get_field_id( 'image' )); ?>';
					function media_upload() {
						let custom_media = true
						let orig_send_attachment = wp.media.editor.send.attachment
						$('body').on('click', `.${selector}`, function () {
						var button_id = $(this).attr('id');
						wp.media.editor.send.attachment = function (props, attachment) {
							if (custom_media) {
									$(`#${selector}`).attr('value', attachment.url)
									$(`.${selector}`).css('background-image', `url('${attachment.url}')`)
									$(`#${selector}`).trigger('change')
									$(`.${selector} #eventr-center`).remove();

							} else {
								return orig_send_attachment.apply($('#' + button_id), [props, attachment]);
							}
						}
						wp.media.editor.open($('#' + selector));
						return false;
						});
					}
					media_upload();

					$(`.${selector} #eventr-bin`).click(function (event) {
						$(`#${selector}`).attr('value', '')
						$(`.${selector}`).css('background-image', '')
						$(`#${selector}`).trigger('change')
						event.preventDefault();
						event.stopPropagation();
					})
				});
			</script>
		</p>

		<!-- Foreground -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'fg' ) ); ?>">
                <?php esc_attr_e( 'Text Color:', 'eventr_domain' ); ?>
            </label>
            <input
				type="color"
                id="<?php echo esc_attr( $this->get_field_id( 'fg' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'fg' ) ); ?>"
				value="<?php echo esc_attr( $fg ); ?>"
            />
		</p>

		<!-- Background -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'bg' ) ); ?>">
                <?php esc_attr_e( 'Background Color:', 'eventr_domain' ); ?>
            </label>
            <input
				type="color"
                id="<?php echo esc_attr( $this->get_field_id( 'bg' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'bg' ) ); ?>"
				value="<?php echo esc_attr( $bg ); ?>"
            />
		</p>

		<!-- Date -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>">
                <?php esc_attr_e( 'Date (Leave for no date):', 'eventr_domain' ); ?>
            </label>
            <input
				type="date"
                id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>"
				value="<?php echo esc_attr( $date ); ?>"
            />
		</p>

		<!-- Description -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
                <?php esc_attr_e( 'Description:', 'eventr_domain' ); ?>
            </label>
            <textarea
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"
				placeholder="Description"
            ><?php echo $description; ?></textarea>
		</p>

		<!-- Form -->
		<p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'form' ) ); ?>">
                <?php esc_attr_e( 'Form:', 'eventr_domain' ); ?>
            </label>
            <input
				type="hidden"
				id="<?php echo esc_attr( $this->get_field_id( 'form' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'form' ) ); ?>"
				value="<?php echo esc_attr( $form ); ?>"
			/>
			<div class="<?php echo esc_attr($this->get_field_id( 'form' )); ?>">
				<div class="cont">

				</div>
				<div>
					<input type="text" placeholder="Enter title" style="width:150px"/>
					<select style="width:80px">
						<option value="text" selected>Text</option>
						<option value="number">Number</option>
						<option value="checkbox">Checkbox</option>
						<option value="select">Select</option>
						<option value="paragraph">Paragraph</option>
					</select>
					<label>Required: </label>
					<input type="checkbox"/>
					<input type="button" value="Add" style="width:40px;color:green"/>
					<div></div>
				</div>
			</div>
			<script>
				function eventrFormUpdate(wpTarget, json) {
					wpTarget.val(JSON.stringify(json))
					wpTarget.trigger('change')
				}
				function eventrProduceList(list) {
					if (list && list.length) {
						return `
						<span style="color:gray">
							[
								<span style="color:black">
									${list.join('</span>, <span style="color:black">')}
								</span>
							]
						</span>`
					}
					return ''
				}
				function eventrListify(json, wpTarget) {
					if (!Array.isArray(json)) {
						console.log('Eventr using compatibility layer...');
						const arr = []
						for (const [key, val] of Object.entries(json)) {
							arr.push({
								title: key,
								type: val.type,
								req: val.req,
								options: val.options
							})
						}
						console.log(arr);
						eventrFormUpdate(wpTarget, arr)
						return arr
					}
					return json
				}
				function eventrFormRender($, json, cont, wpTarget) {
					$(cont).empty()
					if (json) {
						for (const [index, value] of json.entries()) {
							if (value.title == null) continue
							const template = $(`
								<div style="
									display: flex;
									border-bottom: 1px solid gray;
									padding: 10px 0;
								">
									<span style="
										width: 30%;
										max-height: 50px;
										overflow-y: auto;
									"/>
									${value.title}
									</span>
									<span style="
										color:gray;
										flex:1;
										max-height: 50px;
										overflow-y: auto;
										text-align:center;
									">
										(${value.type})
										${value.req ? '<span style="color:red">*</span>' : ''}
										${eventrProduceList(value.options)}
									</span>
								</div>
							`)
							const move = $(`
								<div style="
									display: flex;
									flex-direction: column;
									margin: auto 0;
								"></div>
							`)
							const moveUp = $(`
								<input 
									value="˄"
									type="button"
									style="
										height: 15px;
										font-size: 12px;
									"
								/>
							`)
							const moveDown = $(`
								<input 
									value="˅"
									type="button"
									style="
										height: 15px;
										font-size: 12px;
									"
								/>
							`)
							const remove = $(`
								<input type="button" value="Delete" style="
									width:60px;
									height:22px;
									margin: auto 0;
									color:red
								"/>
							`)
							remove.click(() => {
								json.splice(index, 1)
								template.remove()
								eventrFormUpdate(wpTarget, json)
							})
							moveUp.click(() => {
								if (index > 0) {
									const item = json[index]
									json[index] = json[index - 1]
									json[index - 1] = item
									eventrFormRender($, json, cont, wpTarget)
									eventrFormUpdate(wpTarget, json)
								}
							})
							moveDown.click(() => {
								if (index < json.length - 1) {
									const item = json[index]
									json[index] = json[index + 1]
									json[index + 1] = item
									eventrFormRender($, json, cont, wpTarget)
									eventrFormUpdate(wpTarget, json)
								}
							})
							$(move).append(moveUp)
							$(move).append(moveDown)
							$(template).append(move)
							$(template).append(remove)
							$(cont).append(template)
						}
					}
				}

				jQuery(document).ready(function ($) {
					const selector = '<?php echo esc_attr($this->get_field_id( 'form' )); ?>'
					const wpTarget = $(`#${selector}`)
					const json = eventrListify(JSON.parse($(`#${selector}`)[0].value), wpTarget)
					console.log(json);
					const parent = $(`.${selector}`)[0]
					const cont = parent.children[0]
					// Adding fields
					const addCont = parent.children[1]
					const title = addCont.children[0]
					const type = addCont.children[1]
					const check = addCont.children[3]
					const add = addCont.children[4]
					const list = addCont.children[5]
					eventrFormRender($, json, cont, wpTarget)
					let options = []
					$(type).change(() => {
						setTimeout(() => {
							if (type.value == 'select') {
								while (true) {
									let val = prompt('Add option:')
									for (const item of val.split(',')) {
										options.push(item.trim())
									}
									if (!confirm('Do you want to add another one?')) break;
								}
								list.innerHTML = eventrProduceList(options)
							}
							else {
								options = []
								list.innerHTML = ''
							}
						}, 100);
					})
					$(add).click(() => {
						if (!title.value.trim().length)
							return alert('Title is missing')
						json.push({
							title: title.value,
							type: type.value,
							req: check.checked,
							options
						})
						eventrFormRender($, json, cont, wpTarget)
						eventrFormUpdate(wpTarget, json)
						title.value = ''
						options = []
						list.innerHTML = ''
					})
				})
			</script>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? $new_instance['description'] : '';
		$instance['image'] = ( ! empty( $new_instance['image'] ) ) ? sanitize_text_field( $new_instance['image'] ) : '';
		$instance['fg'] = ( ! empty( $new_instance['fg'] ) ) ? sanitize_text_field( $new_instance['fg'] ) : '';
		$instance['bg'] = ( ! empty( $new_instance['bg'] ) ) ? sanitize_text_field( $new_instance['bg'] ) : '';
		$instance['date'] = ( ! empty( $new_instance['date'] ) ) ? sanitize_text_field( $new_instance['date'] ) : '';
		$instance['form'] = ( ! empty( $new_instance['form'] ) ) ? sanitize_text_field( $new_instance['form'] ) : '';

		return $instance;
	}

}

?>
