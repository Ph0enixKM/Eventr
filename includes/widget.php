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
		$name = get_option('eventr_names_lang');
		$phone = get_option('eventr_phone_lang');
		$age = get_option('eventr_age_lang');
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
				<form>
					<script>
						if (!window.eventr) window.eventr = { }
						window.eventr.text = {
							email: 'Email',
							age: '<?php echo $age == null ? 'Age' : $age ?>',
							name: '<?php echo $name == null ? 'Name' : $name ?>',
							phone: '<?php echo $phone == null ? 'Phone' : $phone ?>',
							mail: '<?php echo $mail == null ? 'New person applied to' : $mail ?>',
							target: btoa('<?php echo $target == null ? 'BAD' : $target ?>'),
							submission: '<?php echo $submission == null ? 'Submission sent' : $submission ?>'
						}
						window.eventr.icons = {
							okay: `<?php echo $icons->okay('white'); ?>`.trim()
						}
					</script>
					<!-- Title -->
					<input class="eventr-input" type="hidden" name="title" value="<?php echo $instance['title'] ?>"/>
					<!-- Name -->
					<input class="eventr-input" type="text" name="name" placeholder="<?php echo $name == null ? 'Full Name' : $name ?>" style="
						border-color: <?php echo $instance['fg']; ?>;
					"/>
					<!-- Email -->
					<input class="eventr-input" type="email" name="email" placeholder="Email" style="
						border-color: <?php echo $instance['fg']; ?>;
					"/>
					<!-- Phone -->
					<input class="eventr-input" type="tel" name="phone" placeholder="<?php echo $phone == null ? 'Phone' : $phone ?>" style="
						border-color: <?php echo $instance['fg']; ?>;
					"/>
					<!-- Age -->
					<input class="eventr-input" type="number" name="age" placeholder="<?php echo $age == null ? 'Age' : $age ?>" style="
						border-color: <?php echo $instance['fg']; ?>;
					"/>
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
				</form>
			</div>
		</div>

		<?php
		// echo 'title: '.$instance['title'].'<br>description: '.$instance['description'];



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

		return $instance;
	}

}

?>